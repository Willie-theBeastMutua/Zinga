<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use common\models\LoginForm;
use app\models\ChangePassword;
use app\models\Users;
use app\models\Data;
use app\models\Timesheets;
use app\models\Support;
use app\models\SupportSubjects;
use common\models\RegisterForm;
use app\models\Indicators;
use app\models\DashboardFilter;
use app\models\Counties;
use app\models\SubCounties;
use app\models\Facilities;
use app\models\AssessmentFacilities;
use app\models\AssessmentSummary;
use app\models\AssessmentIndicators;
use app\models\Assessments;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use yii\db\mssql\PDO;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    //comment
    public $Cache;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'login', 'register', 'error', 'support', 'documentation', 'reset-password',
                            'adultscascade', 'cascadecoverage', 'index', 'infographics', 'community',
                            'about-us', 'apis', 'load', 'dwh', 'cascade', 'currentonart', 'curroveral',
                            'khisdisag', 'cascadeup', 'uptakeclassification', 'uptakeclassificationtwo',
                            'uptakeclassificationtwo_filter', 'getsubcounties', 'paedscascade', 'paedsuptake',
                            'adultsuptake', 'cascadesummary', 'adolescentscascade', 'aypcascade', 'county-data',
                            'getfacilities',
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'change-password', 'support', 'documentation', 'dashboard'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // Add 'dsn' => 'mysql:host=localhost;port=3306;dbname=name' to parameters
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            // return $this->render('dashboard', [
			// ]);
			return $this->redirect(['login']);
		} else {            
			return $this->render('dashboard', [
			]);
		}
    }


    /**
     * Displays Community Page.
     *
     * @return string
     */
    public function actionCommunity()
    {
        return $this->render('community', []);
    }

    /**
     * Displays About Us Page.
     *
     * @return string
     */
    public function actionAboutUs()
    {
        return $this->render('about-us', []);
    }

    /**
     * Displays APIs Page.
     *
     * @return string
     */
    public function actionApis()
    {
        return $this->render('apis', []);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $model->getCurrentUser();
            if ($user->changePassword) {
                return $this->redirect(['reset-password', 'id' => $user->userId]);
            } elseif ($model->login()) {

                return $this->goBack();
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangePassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userId = Yii::$app->user->identity->userId;
            $profile = Users::findOne($userId);
            $profile->passwordHash = Yii::$app->security->generatePasswordHash($model->Password);
            $profile->authKey = Yii::$app->security->generateRandomString();
            $profile->password = '0';
            $profile->password = $model->Password;
            $profile->confirmPassword = $model->ConfirmPassword;
            if ($profile->save()) {
                Yii::$app->session->setFlash('success', 'Password changed successfully.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to change password.');
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($id)
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userId = $id;
            $profile = Users::findOne($userId);
            $profile->passwordHash = Yii::$app->security->generatePasswordHash($model->Password);
            $profile->authKey = Yii::$app->security->generateRandomString();
            $profile->Password = '0';
            $profile->Password = $model->Password;
            $profile->ConfirmPassword = $model->ConfirmPassword;
            $profile->changePassword = 0;
            if ($profile->save()) {
                Yii::$app->session->setFlash('success', 'Password changed successfully.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to change password.');
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionSupport()
    {
        $model = new Support();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Your support Request has been received.');
            return $this->redirect(['support']);
        }

        $supportSubjects = ArrayHelper::map(SupportSubjects::find()->all(), 'supportSubjectId', 'supportSubjectName');
        $users = ArrayHelper::map(Users::find()->andWhere(['=', 'users.deleted', 0])->all(), 'userId', 'FullName');

        return $this->render('support', [
            'model' => $model,
            'supportSubjects' => $supportSubjects,
            'users' => $users,
        ]);
    }

    public function actionDocumentation()
    {
        return $this->render('documentation', []);
    }

    public static function months()
    {
        return [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec'
        ];
    }

    public static function daysOfWeek()
    {
        return [
            1 => 'Sun',
            2 => 'Mon',
            3 => 'Tue',
            4 => 'Wed',
            5 => 'Thu',
            6 => 'Fri',
            7 => 'Sat',
        ];
    }

    public static function ageRange()
    {
        return (object) [
            ['id' => 1, 'name' => 'Under 50'],
            ['id' => 2, 'name' => '50 - 59'],
            ['id' => 3, 'name' => '60 - 69'],
            ['id' => 4, 'name' => '70 - 79'],
            ['id' => 5, 'name' => '80 - 89'],
            ['id' => 6, 'name' => 'Over 90'],
        ];
    }

    public static function groupAges($data)
    {
        $ageRanges = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
        ];

        $ages = $data;
        foreach ($ages as $item) {
            $age = (object) $item;
            // print_r($age); exit;
            if ($age->ageInYears < 50) {
                $ageRanges[1] = $ageRanges[1] + $age->Total;
            } elseif ($age->ageInYears >= 50 && $age->ageInYears <= 59) {
                $ageRanges[2] = $ageRanges[2] + $age->Total;
            } elseif ($age->ageInYears >= 60 && $age->ageInYears <= 69) {
                $ageRanges[3] = $ageRanges[3] + $age->Total;
            } elseif ($age->ageInYears >= 70 && $age->ageInYears <= 79) {
                $ageRanges[4] = $ageRanges[4] + $age->Total;
            } elseif ($age->ageInYears >= 80 && $age->ageInYears <= 89) {
                $ageRanges[5] = $ageRanges[5] + $age->Total;
            } elseif ($age->ageInYears >= 90) {
                $ageRanges[6] = $ageRanges[6] + $age->Total;
            }
        }
        return $ageRanges;
    }

    public function indicatorGraph($indicatorId, $filter)
    {
        $assessmentId = $filter->assessmentId;
        $facilityId = $filter->facilityId;

        $sql = "Select temp.*, dataSourceName, dataSourceId, 'order' From (
                SELECT indicatorId, dataSourceId as dsId, sum(value) as totalValue FROM data_lines
                JOIN data_header on data_header.headerDataId = data_lines.headerDataId
                WHERE indicatorId = :indicatorId AND data_header.facilityId = ':facilityId' AND assessmentId = ':assessmentId'
                GROUP By indicatorId, dataSourceId
                ) temp 
                right JOIN (
                    select ds.* from indicators_data_sources ids
                    JOIN data_sources ds on ds.dataSourceId = ids.dataSourceId
                    where ds.deleted = 0 AND indicatorId = :indicatorId
                    order By ds.order
                ) data_sources on  data_sources.dataSourceId = temp.dsId
                ORDER BY 'order'";
        $model = Data::findBySql($sql, [
            ':indicatorId' => $indicatorId,
            ':facilityId' => $facilityId,
            ':assessmentId' => $assessmentId
        ])->asArray()->all();

        $graph = '[';
        foreach ($model as $key => $column) {
            $graph .= '{ label: "' . $column['dataSourceName'] . '",';
            $graph .= ' value: ' . (int) $column['totalValue'] . ' },';
        }
        $graph .= ']';

        $bar = '[';
        foreach ($model as $key => $column) {
            if ($key + 1 != count($model)) {
                $bar .= '{ y: "' . substr($column['dataSourceName'], 0, 15) . '",';
                $bar .= ' a: ' . (int) $column['totalValue'] . ' },';
            } else {
                $bar .= '{ y: "' . substr($column['dataSourceName'], 0, 15) . '",';
                $bar .= ' a: ' . (int) $column['totalValue'] . ' }';
            }
        }
        $bar .= ']';

        return ['bar' => $bar, 'graph' => $graph, 'data' => $model];
    }

    public function indicatorHighcharts($indicatorId, $aggregator,$filter)
    {
        $countyId = $filter->countyId;
        $facilityId = $filter->facilityId;

        $sql = "Select temp.*, dataSourceName, dataSourceId, 'order', IFNULL(totalValue, 0) as totalValue From (
                SELECT indicatorId, dataSourceId as dsId, sum(value) as totalValue FROM data_lines
                JOIN data_header on data_header.headerDataId = data_lines.headerDataId
                WHERE indicatorId = :indicatorId AND data_header.facilityId = ':facilityId'
                GROUP By indicatorId, dataSourceId
                ) temp 
                right JOIN (
                    select ds.* from indicators_data_sources ids
                    JOIN data_sources ds on ds.dataSourceId = ids.dataSourceId
                    where ds.deleted = 0 AND indicatorId = :indicatorId
                    order By ds.order
                ) data_sources on  data_sources.dataSourceId = temp.dsId
                ORDER BY 'order'";
        $model = Data::findBySql($sql, [
            ':indicatorId' => $indicatorId,
            ':facilityId' => $facilityId
        ])->asArray()->all();

        $dataSources = ArrayHelper::getColumn($model, 'dataSourceName');
        $data = ArrayHelper::getColumn($model, function ($element) {
            return (int) $element['totalValue'];
        });

        $finalData[] = ['name' => 'Values', 'data' => $data];

        $result['categories'] = \json_encode($dataSources);
        $result['data'] = \json_encode($finalData);
        return $result;
    }

    function actionDwh()
    {
        $dataResults = $this->httpClient(1);
        file_put_contents('dwh.json', json_encode($dataResults));
        echo 'Data Loaded';
    }

    public function actionLoad()
    {

        //Check for the last page number for records pulled
        $pageNum = \Yii::$app->db->createCommand("SELECT MAX(pageNumber) pageNumber FROM dwh_lines")->queryScalar();

        //Check for currentpage number and set if not available
        if (empty($pageNum)) {
            $startPage = 1;
        } else {
            //Delete the records for the last page just in case the connection went down before complete download
            //\Yii::$app->db->createCommand("DELETE FROM dwh_lines WHERE pageNumber = '$pageNum' ");
            $startPage = $pageNum;
        }

        //Check for the nubmber of pages to be loaded
        $loadPages = $this->httpClient($startPage);
        $total_page_count = $loadPages['pageCount'];
        //Go throug each page loading and inserting data
        for ($i = $startPage; $i <= $total_page_count; $i++) {
            $dataResults = $this->httpClient($i);
            $subResults = $dataResults['extract'];

            foreach ($subResults as $s) {
                $data_data = [
                    'MFLCode' => $s['MFLCode'],
                    'Gender' => $s['Gender'],
                    'AppointmentsCategory' => $s['AppointmentsCategory'],
                    'ClientStatus' => $s['ClientStatus'],
                    'Stability' => $s['Stability'],
                    'DATIM_AgeGroup' => $s['DATIM_AgeGroup'],
                    'NumPatients' => $s['NumPatients'],
                    'LiveRowId' => $s['LiveRowId'],
                    'PageNumber' => $i
                ];

                \Yii::$app->db->createCommand()->insert('dwh_lines', $data_data)->execute();
            }
        }
        echo count($loadPages) . ' Pages succesfully loaded and processed';
    }

    function httpClient($pageNumber)
    {
        $httpClient = new Client();
        $token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjRCQzlCN0U2MUVCQkU4RUQ0NUY3RUE2M0UzODQzRjkwNDRGNjQ5NjAiLCJ0eXAiOiJhdCtqd3QiLCJ4NXQiOiJTOG0zNWg2NzZPMUY5LXBqNDRRX2tFVDJTV0EifQ.eyJuYmYiOjE2MzY0NTg5MjYsImV4cCI6MTYzNjQ2MjUyNiwiaXNzIjoiaHR0cHM6Ly9kYXRhLmtlbnlhaG1pcy5vcmc6ODQ0MyIsImF1ZCI6InBkYXBpdjEiLCJjbGllbnRfaWQiOiJ0ZXN0Iiwic2NvcGUiOlsicGRhcGl2MSJdfQ.h6--CuYsEBs7L_EjSCKAh4vdD9ZkEpcAGKG0v_xMV8-j1GJIsneQg_1FhhA_Z84vK45_jXERkJh1yrIpfklsidq1tuydIAxkVzMiSW4l9mFrCNPl41hV4bs-uRHliMN1hlHiA09fW15te4Zmvr3OtBmlyQUnoBj-dhnaKbPF5gdhBLGHDKxOOpyF30MbctdVpuIvYpfpKyyG4-QWMbLzRsWNLt7e9Txm5osjgxwdfR0h6yGEy4YzNdj-BxvtRl8Xk_Za2OLAIBg7ZcO0tLhAQsyXdqrfX5q6GnL9pAl_HbRwhDPyKYyx8u8mk4BKJkGPVi_tUg9hQRu3Y3l6It9AHQ";

        $loadPages = $httpClient->get(
            "https://data.kenyahmis.org:9783/api/Dataset?code=MMD&name=PriorityIndicators&pageNumber=$pageNumber&pageSize=300000",
            [
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]
        );
        return json_decode($loadPages->getBody()->getContents(), true);
    }
}
