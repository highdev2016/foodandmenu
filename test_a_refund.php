<?php
error_reporting(1);
$loginname = '7wBx8D5R';
				$transactionkey = '674tq954ZKzchRSB';
				$host = 'https://secure.authorize.net/gateway/transact.dll';
				$path = '/xml/v1/request.api';
require_once 'anet_php_sdk/AuthorizeNet.php'; 
					define("AUTHORIZENET_API_LOGIN_ID", $loginname); 
					define("AUTHORIZENET_TRANSACTION_KEY", $transactionkey); 
					define("AUTHORIZENET_SANDBOX", false); 
					$sale = new AuthorizeNetAIM;
					$sale->amount = 1; 
					$sale->transactionType='refundTransaction';
					$sale->card_num = "XXXX1023"; 
					$sale->exp_date = '122016';
					$sale->description = "Deal Purchase";
					$sale->first_name = 'test'; 
					$sale->last_name ='test'; 
					$sale->address ='fghfff gffff';
					$sale->city ='ghg';
					$sale->state = 'ffsf';
					$sale->zip = '24442';
					$sale->phone = '21321312332';
					$sale->email = "test@test.com";
					$response = $sale->authorizeAndCapture(); 
					
					echo $response;
			//-----------------------------refund--request-----------------------------------------------------------------//		
					
					
					
					/*$sale->createTransactionRequest(array(
					'refId' => rand(1000000, 100000000),
					'transactionRequest' => array(
						'transactionType' => 'refundTransaction',
						'amount' => 1.00,
						'payment' => array(
							'creditCard' => array(
								'cardNumber' => 'XXXX1023',
								'expirationDate' => '122016',
								'refTransId' => '4926823799'
							)
						),
						'authCode' => '2165668159'
					),
				));
				*/
				
	?>			