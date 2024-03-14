<?php

/*

*/
// use app\models\Smsoutgoing;

require_once('AfricasTalkingGateway.php');

function send_sms($recipients, $message, $Origin)
{
	$username   = 'ngugijmn';
	$apikey     = '95f5c71965348701be35af3c090b6c2265f982dba37121a6347e5d9e05b5ddc1';

	// Create a new instance of our awesome gateway class
	$gateway    = new AfricasTalkingGateway($username, $apikey);
	try {
		// Thats it, hit send and we'll take care of the rest.
		$results = $gateway->sendMessage($recipients, $message, $Origin);

		// print_r($results); exit;

		foreach ($results as $result) {
			/*
			// status is either "Success" or "error message"
			echo " Number: " .$result->number;
			echo " Status: " .$result->status;
			echo " MessageId: " .$result->messageId;
			echo " Cost: "   .$result->cost."\n";
			*/
			
			return true;
		}
	} catch (AfricasTalkingGatewayException $e) {
		return false;
		//echo "Encountered an error while sending: ".$e->getMessage();
	}
}
