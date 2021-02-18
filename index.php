<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = str_replace('\\', '/', __DIR__);

// setup composer autoloader
require_once $root . '/vendor/autoload.php';

use xenframe\hello\Main;

$hi = new Main();

echo $hi->hi();