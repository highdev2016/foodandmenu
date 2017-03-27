<?php



include("authnetfunction_helper.php");


$xml = new AuthnetXML(AUTHNET_LOGIN, AUTHNET_TRANSKEY);

$xml->createTransactionRequest(array(
    'refId' => rand(1000000, 100000000),
    'transactionRequest' => array(
        'transactionType' => 'refundTransaction',
        'amount' => 1.00,
        'payment' => array(
            'creditCard' => array(
                'cardNumber' => 'XXXX1014',
                'expirationDate' => '122025',
            )
        ),
        'refTransId' => '4928163616',
        'transactionSettings' => array(
            'setting' => array(
                0 => array(
                    'settingName' => 'emailCustomer',
                    'settingValue' => 'true'
                ),
            )
        ),
    ),
));

/*echo '<pre>';
					print_r($response);
					echo '</pre>';
					exit;*/

?>