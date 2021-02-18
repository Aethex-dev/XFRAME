<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = str_replace('\\', '/', __DIR__);

// setup composer autoloader
require_once $root . '/vendor/autoload.php';

use xenframe\MvcLibrary\Hello;

$comp = new Hello();
// no u dont get it, i reverted to show u, the xenframe folde rdont even show in github, ok ill install another package and then watch
echo $comp->say(3432432423432); // yeah, but then you reinstalled it , ok now ima check changes and stage them