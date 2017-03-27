<?php
error_reporting(1);
  require 'autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;

  define("AUTHORIZENET_LOG_FILE", "phplog");

  function refundTransaction($amount){
    // Common setup for API credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName("9U6b68Xafah");
    $merchantAuthentication->setTransactionKey("3T274U3nZv73ttRH");
	$refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber("4111111111111111");
    $creditCard->setExpirationDate("12-2017");
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);
    //create a transaction
    $transactionRequest = new AnetAPI\TransactionRequestType();
    $transactionRequest->setTransactionType( "refundTransaction"); 
    $transactionRequest->setAmount($amount);
    $transactionRequest->setPayment($paymentOne);
    $customer = new AnetAPI\CustomerDataType();
    $customer->setId("CUST001");
    $transactionRequest->setCustomer($customer);

    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest( $transactionRequest);
	// var_dump($request);
	 
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	var_dump($response);
	
    if ($response != null)
    {
      $tresponse = $response->getTransactionResponse();
      if (($tresponse != null) && ($tresponse->getResponseCode()== "1") )   
      {
        echo "Refund SUCCESS: " . $tresponse->getTransId() . "\n";
      }
      else
      {
        echo  "Refund ERROR : " . $tresponse->getResponseCode() . "\n";
      }
      
    }
    else
    {
      echo  "Refund Null response returned";
    }
    return $response;
  }
  //if(!defined('DONT_RUN_SAMPLES'))
    refundTransaction("10.10");
?>