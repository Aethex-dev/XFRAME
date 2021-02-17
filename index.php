<?php

$root = str_replace('\\', '/', __DIR__);

// setup composer autoloader
require_once $root . '/vendor/autoload.php';

use xenframe\mvc;

$hi = new App();

echo $hi->hi();