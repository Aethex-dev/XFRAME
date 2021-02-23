<?php

// set app variables
$root = str_replace('\\', '/', __DIR__);

// include utility functions
require_once($root . '/src/utils.php');

include 'vendor/autoload.php';

use xframe\Router\App;

$url = new App();

dumpf($url->get_url());