<?php

namespace xframe\framework;

/** 
 * FILENAME: portal.php
 * DESCRIPTION: routes user to public index page
 * AUTHORS: XENONMC XFRAME
*/

// get config
$config = json_decode(file_get_contents('config.json'), true);

// check php version
$php_min_version = "OC4wLjA=";
$php_min_version = base64_decode($php_min_version);

if($config['ignore-php-version'] !== true) {
    if (version_compare(phpversion(), $php_min_version, "<")) {
        die("<p style = 'font-family: sans-serif; font-size: 13px;'><strong>ERROR: The minimum version of PHP must be " . $php_min_version . " for this software to work.  Your PHP version is " . phpversion() . ".  Please upgrade your PHP version to " . $php_min_version . " or higher, or ask you host to upgrade your version.</strong></p>");
    }
}

// require composer
require_once $root . '/vendor/autoload.php';

/** 
 * framework class
 * 
 * @param bool, use testing class
 * 
*/

class xframe {

    /** 
     * router object
     * 
    */

    private router $router;

    /** 
     * model object
     * 
    */

    private $model;

    /** 
     * controller object
     * 
    */

    private $controller;

    /** 
     * view object
     * 
    */

    private $view;

    function __construct($use_testing) {

        $root = str_replace('\\', '/', __DIR__);

        // require utils
        require_once $root . '/src/utils.php';

        // start framework classes
        if($use_testing === true) {
            $this->testing();
            return null;
        }
        
        $this->main();
        return null;

    }

    /** 
     * main class
     * 
    */

    function main() {

        // setup router
        $router = new \xframe\Router\App();

        dumpf($router->get_url());

        echo $router->get_request_app();

        echo $router->get_request_action();

        dumpf($router->get_app_config('About'));

        $router->get_all_apps();

        // initialize router
        
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

$xframe = new xframe($config['developer-mode']);