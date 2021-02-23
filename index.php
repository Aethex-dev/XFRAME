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

    function __construct($use_testing = false) {

        $root = str_replace('\\', '/', __DIR__);

        // require utils
        require_once $root . '/src/utils.php';

        // require composer
        require_once $root . '/vendor/autoload.php';

        // start framework classes
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

        // setup url
        $router = new \xframe\Router\App();

        dumpf($router->get_url());
        
    }

    /** 
     * testing class
     * 
    */

    function testing() {

    }

}

/** 
 * execute framework
 * 
*/

$xframe = new xframe(false);