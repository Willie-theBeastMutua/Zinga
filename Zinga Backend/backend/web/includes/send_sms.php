<?php

/*

*/
// use app\models\Smsoutgoing;

require_once('AfricasTalkingGateway.php');

function send_sms($recipients, $message, $Origin)
{
	$username   = 'tafutaa';
	$apikey     = 'b50a89e5a6beb66ff7e02c3161d1712cabd2d0885f9115662a6817d2341909c0';

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
