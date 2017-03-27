<?php
/**
 * Custom SPL autoloader for the AuthorizeNet SDK
 *
 * @package AuthorizeNet
 */

spl_autoload_register(function($className) {
    static $classMap;

    if (!isset($classMap)) {
        $classMap = require 'classmap.php';
    }

    if (isset($classMap[$className])) {
        include $classMap[$className];
    }
});
