<?php
error_reporting(1);
//$baseDir = __DIR__ ;
//echo $baseDir;
echo "RR";
  //require 'vendor/autoload.php';
  require 'autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;
  define("AUTHORIZENET_LOG_FILE", "phplog");
  // Common setup for API credentials
   
  
  $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
  $merchantAuthentication->setName("9U6b68Xafah");
  $merchantAuthentication->setTransactionKey("3T274U3nZv73ttRH");
  $refId = 'ref' . time();
  // Create the payment data for a credit card
  
  $creditCard = new AnetAPI\CreditCardType();
  $creditCard->setCardNumber( "4111111111111111" );
  $creditCard->setExpirationDate( "122016");
  $paymentOne = new AnetAPI\PaymentType();
  $paymentOne->setCreditCard($creditCard);
  //create a transaction
  echo "dd1";
  $transactionRequestType = new AnetAPI\TransactionRequestType("refundTransaction");
  
  $transactionRequestType->setTransactionType(); 
  $transactionRequestType->setAmount(151.21);
   
  $transactionRequestType->setPayment($paymentOne);
  
  $request = new AnetAPI\CreateTransactionRequest();
  $request->setMerchantAuthentication($merchantAuthentication);
  $request->setRefId( $refId);
  
  
  $request->setTransactionRequest($transactionRequestType);
 
   print_r($request);
 
 
 
  $controller = new AnetController\CreateTransactionController($request);
  echo "dd5678";
  
  
  
  $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
  
  var_dump($response);
  
  if ($response != null)
  {
    $tresponse = $response->getTransactionResponse();
    if (($tresponse != null) && ($tresponse->getResponseCode()=="1") )   
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
 
?>
