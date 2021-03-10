<?php

namespace xframe;

/** 
 * XFRAME MVC Framework
 * 
 * Version: 1.0.0
 * Authors: XENONMC
 * PHP Version: 8.0.2
 * 
*/

/** 
 * NOTE: XFRAME does not have an index file, instead, It stores pages in apps. The default app can be found it [ src/apps ]
 * 
 * Other than that, Happy Coding!
 * 
*/

// ini set
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// load dependencies
include 'vendor/autoload.php';
include 'src/utils.php';

// construct framework
$mvc = new \xframe\Mvc\App();
