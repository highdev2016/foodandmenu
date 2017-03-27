<?php

// PreShared Key entered on MMS. The demo accounts is fixed, but merchant accounts can be
// updated from the MMS .
$pre_shared_key = "Circle4Take40Idea";

// Hasing Method, Supported Methods are: SHA512 (preferred), SHA256, SHA1, MD5, CRC32
$hashing_method = "SHA512";

// Build Request
/*$req = array(
    "merchantID" => "100856",
    "action" => "SALE",
    "type" => 1,
    "transactionUnique" => uniqid(),
    "currencyCode" => 826,
    "amount" => 1001,
    "orderRef" => "Test purchase",
    "cardNumber" => "4012001037141112",
    "cardExpiryMonth" => 12,
    "cardExpiryYear" => 15,
    "cardCVV" => '083',
    "customerName" => "CardStream",
    "customerEmail" => "solutions@cardstream.com",
    "customerPhone" => "+44 (0) 845 00 99 575",
    "customerAddress" => "16 Test Street",
    "countryCode" => 826,
    "customerPostCode" => "TE15 5ST",
    "threeDSMD" => (isset($_REQUEST['MD']) ? $_REQUEST['MD'] : null),
    "threeDSPaRes" => (isset($_REQUEST['PaRes']) ? $_REQUEST['PaRes'] : null),
    "threeDSPaReq" => (isset($_REQUEST['PaReq']) ? $_REQUEST['PaReq'] : null)
);*/

$req = array(
    "merchantID" =>"100001", //"100856",
    "action" => "SALE",
    "type" => 1,
    "transactionUnique" => uniqid(),
    "currencyCode" => 840,//826,//
    "amount" => 1001,//1001,//
    "orderRef" => "Test purchase",
    "cardNumber" => 4539791001730106,//"4012001037141112",
    "cardExpiryMonth" => 12,//12,
    "cardExpiryYear" => 15,//15,
    "cardCVV" => 289,//'083',
    "customerName" => 'CardStream',//"CardStream",
    "customerEmail" => 'solutions@cardstream.com',//"solutions@cardstream.com",
    "customerPhone" => '+44 (0) 845 00 99 575',//"+44 (0) 845 00 99 575",
    "customerAddress" => 'Unit 5 Pickwick Walk 120 Uxbridge Road Hatch End Middlesex',//"16 Test Street",
    "countryCode" => 826,//826,
    "customerPostCode" => 'HA6 7HJ',//"TE15 5ST",
    "threeDSMD" => (isset($_REQUEST['MD']) ? $_REQUEST['MD'] : null),
    "threeDSPaRes" => (isset($_REQUEST['PaRes']) ? $_REQUEST['PaRes'] : null),
    "threeDSPaReq" => (isset($_REQUEST['PaReq']) ? $_REQUEST['PaReq'] : null)
);

// Data must be sorted by key
ksort($req);

// Build the signature field and concatenate the key to the end
$signature_fields = http_build_query($req) . $pre_shared_key;

// Make a hash of the fields
$hash = hash($hashing_method, $signature_fields);

// Add Signature field to the end of the request. If you are using the the default hashing
// method(SHA512) it does not need to be sent
$req['signature'] = ($hashing_method != "SHA512" ? "{" . $hashing_method . "}" : "") . $hash;


$ch = curl_init('https://gateway.cardstream.com/direct/');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($req));
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
parse_str(curl_exec($ch), $res);
curl_close($ch);

if ($res['responseCode'] == 65802) {

// Send details to 3D Secure ACS and the return here to repeat request

    $pageUrl = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageUrl .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageUrl .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

    echo "<p>Your transaction requires 3D Secure Authentication</p>
          <form action=\"" . htmlentities($res['threeDSACSURL']) . "\" method=\"post\">
            <input type=\"hidden\" name=\"MD\" value=\"" . htmlentities($res['threeDSMD']) . "\">
            <input type=\"hidden\" name=\"PaReq\" value=\"" . htmlentities($res['threeDSPaReq']) . "\">
            <input type=\"hidden\" name=\"TermUrl\" value=\"" . htmlentities($pageUrl) . "\">
            <input type=\"submit\" value=\"Continue\">
         </form>";

} elseif (isset($res['signature'])) {

    $return_signature = $res['signature'];

    // Remove the signature as this isn't hashed in the return
    unset($res['signature']);

    // Sort the returned array
    ksort($res);

    // The returned hash will always be SHA512
    if ($return_signature == hash("SHA512", http_build_query($res) . $pre_shared_key)) {

        echo "<p>Signature Check OK!</p>" . PHP_EOL;

        if ($res['responseCode'] === "0") {

            echo "<p>Thank you for your payment</p>" . PHP_EOL;

        } else {

            echo "<p>Failed to take payment: " . htmlentities($res['responseMessage']) . "</p>" . PHP_EOL;
        }
    } else {

        die("Sorry, the signature check failed");

    }
} else {

    if ($res['responseCode'] === "0") {

        echo "<p>Thank you for your payment</p>";

    } else {

        echo "<p>Failed to take payment: " . htmlentities($res['responseMessage']) . "</p>" . PHP_EOL;

    }
}
