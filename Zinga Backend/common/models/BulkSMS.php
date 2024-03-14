<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\AfricasTalking;
use app\models\Sms;

/**
 * Login form
 */
class BulkSMS extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;

	private $_user;

	function send_sms($recipients, $message, $Origin='NASCOP')
	{
		$username   = 'HEALTHSTRAT--';
		$apikey     = 'e67cbe22f4f71241ae487aa77414e63a911f9a3731a691f3c0f49746e97c1a01';
	
		// Create a new instance of our awesome gateway class
		$gateway    = new AfricasTalking($username, $apikey);
		try {
			// Thats it, hit send and we'll take care of the rest.
			$results = $gateway->sendMessage($recipients, $message, $Origin);
            
	
			foreach ($results as $result) {
                $this->saveSMS($result, $message, $Origin);
                
				/*
				// status is either "Success" or "error message"
				echo " Number: " .$result->number;
				echo " Status: " .$result->status;
				echo " MessageId: " .$result->messageId;
				echo " Cost: "   .$result->cost."\n";
				*/
			}

            return $results;
		} catch (AfricasTalkingGatewayException $e) {
            if (!is_array($recipients)) {
                $numbers[0] = $recipients;
            }
            
            // save all failed messages
            foreach ($numbers as $recipient) {
                $res['statusCode'] = 500;
                $res['number'] = $recipient;
                $this->saveSMS((object) $res, $message, $Origin);
            }

            $result[0]['statusCode'] = 500;
            return json_decode (json_encode ($result), FALSE);
			// return false;
			// echo "Encountered an error while sending: ".$e->getMessage();
		}
	}

    private function saveSMS($result, $message, $Origin)
    {
        $sms = new Sms();
        $sms->origin = $Origin;
        $sms->destination = $result->number;
        $sms->message = $message;
        $sms->smsStatusId = $result->statusCode;
        // $sms->createdBy = 1;
        $sms->save();
    }
}