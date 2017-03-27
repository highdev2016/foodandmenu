<?php
    define('AUTHNET_LOGIN', '9U6b68Xafah');
    define('AUTHNET_TRANSKEY', '3T274U3nZv73ttRH');

    if (!function_exists('curl_init'))
    {
        throw new Exception('CURL PHP extension not installed');
    }

    if (!function_exists('simplexml_load_file'))
    {
        throw new Exception('SimpleXML PHP extension not installed');
    }

?>