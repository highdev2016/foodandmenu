<?php
require_once('./vendor/autoload.php');

$stripe = array(
  "secret_key"      => "sk_test_YLhJXYuerpcIoMNyOEVBuxa8",
  "publishable_key" => "pk_test_4FrKB3bjPZ4I7w4OVVaRwRRK"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);