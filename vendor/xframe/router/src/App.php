<?php

namespace xframe\Router;

class App {

    /** 
     * get requested url
     * 
     * @return array, array of url parameters
     * 
    */

    function get_url() {

        $unparsed = $_SERVER['REQUEST_URI'] ?? '/';

        if($unparsed === '/') {
            $parsed = array_pad(array('/'), 20, "");
        } else {
            $unparsed = array_pad(explode("/", $unparsed, 20), 20, "");
            array_shift($unparsed);
            $parsed = $unparsed;

        }

        return $parsed;

    }

    /** 
     * get requested application
     * 
     * @return string, name of the requested application
     * 
    */

    function get_request_app($home_app = 'index') {

        $url = $this->get_url();

        if($url[0] == '/') {
            return $home_app;
        }
        
        return $url[0];
        
    }

    /** 
     * check if application exists
     * 
     * @param string, app name
     * 
     * @return bool, returns if the application name exists
     * 
    */

    function app_exists($app) {

        if(file_exists(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'])) . '/src/apps/' . $this->get_request_app() . '/App.php') {
            return true;
        }

        return false;

    }

    /** 
     * get all applications
     * 
     * @return array, array of all the applications
     * 
    */

    function get_all_apps() {

        $apps = scandir(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) . '/src/apps/', 1);
        var_dump($apps);
        for($x = 0; $x <= 1; $x++) {
            $apps = array_pop($apps);
        }

        foreach($apps as $app) {
            echo $app;
        }

    }

    /** 
     * check if the url action parameter was set
     * 
     * @return bool, returns if the action url parameter was set
     * 
    */

    function action_isset() {

        $url = $this->get_url();

        if(strlen($url[1]) > 1) {
            return true;
        }

        return false;

    }

    /** 
     * get requested action
     * 
     * @return string, name of the action
     * 
    */

    function get_request_action() {

        $url = $this->get_url();

        if($this->action_isset($url[1])) {
            return $url[1];
        }

        return 'Main';

    }

    /** 
     * get application config
     * 
     * @param string, name of the application
     * 
     * @return array, json data
     * 
    */

    function get_app_config($app) {

        $config = file_get_contents(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) . '/src/apps/' . $app . '/config.json');
        $json = json_decode($config);
        return $json;

    }

}
