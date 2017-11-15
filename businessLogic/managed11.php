<?php
/********************************************
	Prepare data for PayPal API calls and process API response
	********************************************/
	include_once('paypalConfig.php');
	include_once('paypalFunctions.php');
/*
	* Purpose: 	Prepare data to call the get access token API
	* Inputs:
	* Returns:  access token
	*
	*/
function buildAndProcessGetAccessToken(){
	$base6encodedPartnerAuth = base64_encode(PARTNER_CLIENT_ID.':'.PARTNER_CLIENT_SECRET);
    $curlHeader = array(
       "Content-type" => "application/json",
       "Authorization: Basic ".$base6encodedPartnerAuth,
       "PayPal-Partner-Attribution-Id" => PARTNER_BN_CODE
       );
    $postData = array(
       "grant_type" => "client_credentials"
       );

    $curlResponse = getAccessToken($curlHeader, $postData);
    //print_r($curlResponse);
    $access_token = $curlResponse['json']['access_token'];
    return $access_token;
}

/*
	* Purpose: 	Prepare data to call the MAM merchant
	* Inputs:
	*		access_token    : The access token received from PayPal
	* Returns:              action URL
	*/
function buildAndProcessMAM($access_token, $postData){

	$curlHeader = array("Content-Type:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".PARTNER_BN_CODE);
	$jsonResponse = callMAM($access_token, $curlHeader, $postData);

    //print_r($jsonResponse);
	foreach ($jsonResponse['json'] as $link) {
	    //print_r($link);
		//$action_url = $link['errors'][0]['href'];
		//print_r($action_url);
		return $link;
	}
}

/*
	* Purpose: 	Prepare data to call the PayPal Risk transaction context API
	* Inputs:
	*		access_token    : The access token received from PayPal
	* Returns:              curlResponse
	*/
function buildAndProcessRiskContextCall($access_token, $postData){

	$curlHeader = array("Content-Type:application/json","Accept:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".PARTNER_BN_CODE, "X-HTTP-Method-Override: PUT");
	$partnerID = PARTNER_ID;
	$curlResponse = callRiskTransactionContext($access_token, $curlHeader, $partnerID, $postData);

	//print_r($curlResponse);
	return $curlResponse;
}


/*
	* Purpose: 	Prepare data to call the PayPal Create Order MAM
	* Inputs:
	*		access_token    : The access token received from PayPal
	* Returns:              Approval URL to redirect the user to
	*/
function buildAndProcessCreateOrderCall($access_token, $postData){

	//print_r($postData);
	$curlHeader = array("Content-Type:application/json","Accept:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id: GoFundMe_SP");
	$curlResponse = callCreateOrder($access_token, $curlHeader, $postData);
	$jsonResponse = $curlResponse['json'];
    //print_r($jsonResponse);
	$_SESSION['order_id'] = $jsonResponse['id']; //Save the order ID in session
	foreach ($jsonResponse['links'] as $link) {
		if($link['rel'] == 'approval_url'){
			$approval_url = $link['href'];
			return $approval_url;
		}
	}
}

/*
	* Purpose: 	Prepare data to call the Pay for Order API
	* Inputs:
	*		access_token    : The access token received from PayPal
	* Returns:              Pay for Order JSON response
	*/
function buildAndProcessPayForOrderCall($access_token, $orderID, $payForOrderRequestData){

	$curlHeader = array("Content-Type:application/json","Accept:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id: GoFundMe_SP");
	$curlResponse = callPayForOrder($access_token, $curlHeader, $orderID, $payForOrderRequestData);
	$jsonResponse = $curlResponse['json'];

    //print_r($curlResponse);
	return $jsonResponse;
}

/*
	* Purpose: 	Prepare data to call the get order status API.
 	* Gets the Capture ID needed to make Disburse/Refund calls for a Particular Purchase Unit
	* Inputs:
	*		access_token    : The access token received from PayPal
	* Returns:              Capture ID for a purchase unit, if the Capture ID is generated
	*/
function buildAndProcessGetCaptureIDFromPurchaseUnit($access_token, $orderID, $purchaseUnitId){

	if(WEBHOOK_CONFIGURED){
		//Get Capture ID data from WebHook
	} else {
		$curlHeader = array("Content-Type:application/json","Accept:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".PARTNER_BN_CODE);
		$curlResponse = callGetOrderStatus($access_token, $curlHeader, $orderID);
		$jsonResponse = $curlResponse['json'];

		if(!isset($jsonResponse['purchase_units'][$purchaseUnitId])){
			echo("Invalid Purchase Unit Id");
		} else if(sizeof($jsonResponse['purchase_units'][$purchaseUnitId]['payment_summary']) == 0){
			echo("Capture ID not yet Generated");
		} else {
			return $jsonResponse['purchase_units'][$purchaseUnitId]['payment_summary']['captures'][0]['id']; //return the Capture ID for the Requested Purchase Unit
		}

	}
}

/*
 * Purpose: Prepare data to call the pay API for payment that was on hold.
 * Inputs:
 *		access_token    : The access token received from PayPal
 * Returns:              Disburse Call status
 */
function buildAndProcessDisburseCall($access_token, $captureID, $disburseRequestData){
	if ($captureID === NULL) {
		return;
	}

	$curlHeader = array("Content-Type:application/json","Accept:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".PARTNER_BN_CODE, "Prefer:respond-sync");

	//update the request info
	$disburseReqArray = json_decode($disburseRequestData, true);
	$disburseReqArray['reference_id'] = $captureID;
	$disburseRequestData = json_encode($disburseReqArray);

	$curlResponse = callDisburse($access_token, $curlHeader, $captureID, $disburseRequestData);
	$jsonResponse = $curlResponse['json'];

	//print_r($curlResponse);

	$status = $jsonResponse['processing_state']['status'];
	return $status;
}

/*
 * Purpose: Prepare data to call the refund API to refund the payment.
 * Inputs:
 *		access_token    : The access token received from PayPal
 * Returns:              Refund Call state
 */
function buildAndProcessRefundCall($access_token, $captureID, $refundRequestData){

	$paypalAuthAssertionCommonHeader = '{"alg":"none"}';
	$paypalAuthAssertionPayload = '{"iss": "'.PARTNER_CLIENT_ID.'", "payer_id":"'.SELLER_1_PAYER_ID.'"}';
	$paypalAuthAssertionHeader = base64_encode($paypalAuthAssertionCommonHeader).'.'.base64_encode($paypalAuthAssertionPayload).'.';
	//echo('PayPal Auth Header :'.$paypalAuthAssertionHeader);
	$curlHeader = array("Content-Type:application/json","Accept:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".PARTNER_BN_CODE, "PayPal-Auth-Assertion:".$paypalAuthAssertionHeader);

	//update the request info
	$refundReqArray = json_decode($refundRequestData, true);
	$refundReqArray['amount']['currency'] = "USD";
	$refundReqArray['amount']['total'] = "100";
	$refundRequestData = json_encode($refundReqArray, JSON_FORCE_OBJECT);

	$curlResponse = callRefund($access_token, $curlHeader, $captureID, $refundRequestData);
	$jsonResponse = $curlResponse['json'];

	//print_r($jsonResponse);

	$state = $jsonResponse['state'];
	return $state;
}

?>