import requests
from flask import Flask
from flask_mysqldb import MySQL

app = Flask(__name__)
# Load configuration
app.config.from_object('config.BaseConfig')

mysql = MySQL(app)


def get_facility_params(datasource_id):
    sql = "SELECT * FROM  org_unit_data_sources WHERE dataSourceId = %s "
    value = datasource_id
    facilities = fetch_records_with_condition(sql, value)
    return facilities


def fetch_records_with_condition(sql, values):
    cursor = mysql.connection.cursor()
    cursor.execute(sql, values)
    result = cursor.fetchall()
    cursor.close()
    return result


def fetch_records(sql):
    cursor = mysql.connection.cursor()
    cursor.execute(sql)
    result = cursor.fetchall()
    cursor.close()
    return result


def get_indicator_params(datasource_id):
    sql = "SELECT indicatorId, uId FROM  indicators_data_sources " \
          "WHERE dataSourceId= %s AND uId IS NOT NULL"
    value = datasource_id
    indicators = fetch_records_with_condition(sql, value)
    return indicators


def make_endpoint(url, indicator, period, facility):
    if indicator is None:
        indicator = ''
        endpoint = url + "dimension=dx:" + indicator + "&dimension=ou:" + facility + "&dimension=pe:" + period
        return endpoint
    else:
        endpoint = url + "dimension=dx:" + indicator + "&dimension=ou:" + facility + "&dimension=pe:" + period
        return endpoint


def get_server_request(endpoint):
    surl = app.config['KHIS_URL']
    username = app.config['KHIS_USERNAME']
    password = app.config['KHIS_SECRET']
    session = get_server_connection(surl, username, password)
    result = session.get(endpoint)
    return result.json()


def insert_records(sql, values):
    cursor = mysql.connection.cursor()
    cursor.execute(sql, values)
    mysql.connection.commit()
    cursor.close()

    return cursor.lastrowid


def get_server_connection(serverUrl, username, password):
    server = requests.Session()
    server.auth = (username, password)
    adapter = requests.adapters.HTTPAdapter(pool_connections=100, pool_maxsize=100)
    server.mount(serverUrl, adapter)
    return server


@app.route('/', methods=['GET'])
def home():
    # base url
    base_url = app.config['KHIS_API']
    period = '202108'
    # fetch facilities where datasource is KHIS
    facilities = get_facility_params('1')
    # print(facilities)
    for facility in facilities:
        print(facility)
        indicators = get_indicator_params('1')
        # indicators = ['f9vesk5d4IY', 'BLQqoPPTxQu', 'uvBuzBj0AbL', 'lJpaBye9B0H', 'WNFWVHMqPv9', 'ckPCoAwmWmT','vkOYqEesPAi', 'UMyB7dSIdz1']
        for indicator in indicators:
            print(indicator)
            endpoints = make_endpoint(base_url, indicator[1], period, facility[2])
            print(endpoints)
            data = get_server_request(endpoints)
            print(data)
            if "dataValues" not in data:
                print("empty values")
            else:
                for values in data["dataValues"]:

                    data_header_check_sql = "SELECT headerDataId FROM data_header WHERE dataSourceId=%s AND facilityId=%s " \
                                            " AND monthId=%s AND year=%s AND createdBy=%s "
                    data_header_check_values = [indicator[0], facility[0], period[5], period[0:4], 1]
                    data_header_check = fetch_records_with_condition(data_header_check_sql, data_header_check_values)
                    if data_header_check:
                        data_header_sql = "UPDATE data_header SET dataSourceId=%s,facilityId=%s," \
                                          "monthId=%s,year=%s " \
                                          "WHERE headerDataId=%s "
                        data_headers = [indicator[0], facility[0], period[5], period[0:4],
                                        int(data_header_check[0][0])]
                        insert_records(data_header_sql, data_headers)
                        header_data_id = int(data_header_check[0][0])
                        print('updated')
                    else:
                        data_header_sql = "INSERT INTO data_header (dataSourceId,facilityId, periodTypeId," \
                                          "monthId," \
                                          "year,createdBy) VALUES (%s, %s, %s, %s, %s, %s) "
                        data_headers = [1, facility[0], '1', '9', '2021', 1]
                        header_data_id = insert_records(data_header_sql, data_headers)
                        print('inserted')

                    data_lines_check_sql = "SELECT headerDataId, indicatorId FROM data_lines WHERE headerDataId=%s AND indicatorId=%s AND createdBy=%s "
                    data_lines_check_values = [header_data_id, indicator[0], 1]
                    data_lines_check = fetch_records_with_condition(data_lines_check_sql, data_lines_check_values)
                    if data_lines_check:
                        print('updating' + str(int(data_lines_check[0][0])))
                        data_lines_sql = "UPDATE data_lines SET value=%s WHERE headerDataId=%s AND indicatorId=%s"
                        data_lines = [values["value"], int(data_lines_check[0][0]), indicator[0]]
                        insert_records(data_lines_sql, data_lines)
                        uid = int(data_lines_check[0][0])
                        print('updated lines')
                    else:
                        data_lines_sql = "INSERT INTO data_lines (headerDataId,indicatorId,dataCategoryId,value,createdBy) VALUES (" \
                                         "%s, %s, %s, %s, %s) "
                        data_lines = [header_data_id, indicator[0], 1, values["value"], 1]
                        uid = insert_records(data_lines_sql, data_lines)
                        print('inserted lines')
    success = " completed successfully"
    return success


app.run()
