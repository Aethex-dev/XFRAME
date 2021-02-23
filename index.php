<?php

/** 
 * FILENAME: portal.php
 * DESCRIPTION: routes user to public index page
 * AUTHORS: XENONMC XFRAME
*/

/** 
 * framework class
 * 
 * @param bool, use testing class or main class. true = testing, false = main
 * 
*/

namespace xframe\framework;

class xframe {

    /** 
     * constructor
     * 
    */

    function __construct($use_testing) {
        if($use_testing == true) {
            $this->testing();
            return 0;
        } else {
            $this->main();
        }
    }

    /** 
     * main class
     * 
    */

    function main() {

    }

    /** 
     * testing class
     * 
    */

    function testing() {

    }

}

// set app variables
$root = str_replace('\\', '/', __DIR__);

// include utility functions
require_once($root . '/src/utils.php');

include 'vendor/autoload.php';

use xframe\Router\App;

$url = new App();