<?php

error_reporting(E_ALL | E_STRICT);

set_include_path(__DIR__ . '/library' . PATH_SEPARATOR .
                 __DIR__ . '/../library' . PATH_SEPARATOR .
                 get_include_path());

require_once '../vendor/autoload.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('ZFBootstrap\\');
$autoloader->setFallbackAutoloader(true);
