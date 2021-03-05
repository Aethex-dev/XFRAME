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

        // get unparsed uri
        $path = $_SERVER['REQUEST_URI'];

        $path_elements = explode("/", $path);
        $tempPI = "";

        if (isset($path_elements[2])){

            for ($i = 2 ;$i < count($path_elements); $i++ ) {

                $tempPI .= "/".$path_elements[$i];

            }

        }

        $unparsed = $tempPI;

        // split url to array
        if($unparsed === '/') {

            $parsed = array_pad(array('/'), 20, "");

        } else {

            $unparsed = array_pad(explode("/", $unparsed, 20), 20, "");
            array_shift($unparsed);
            $parsed = $unparsed;

        }

        // set empty values for left over url segments
        for ($i = 0 ; $i == 20; $i++) {

            if(!isset($parsed[$i])) {

                $parsed[$i] = "";

            }

        }

        // return parsed url array
        return $parsed;

    }

    /** 
     * get requested application
     * 
     * @return string, name of the requested application
     * 
    */

    function get_request_app($home_app = 'Index') {

        // get page url
        $url = $this->get_url();

        // check if on homepage
        if($url[0] == '/') {

            return $home_app;

        }

        // return application name based on url
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

        // check if application main class exists
        if(file_exists(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'])) . '/src/apps/' . $this->get_request_app() . '/App.php') {

            return true;

        }

        return false;

    }

    /** 
     * check if the action exists
     * 
     * @param string, name of the action
     * 
     * @return bool, return if the action name exists
     * 
    */

    function action_exists($action, $app = null) {

        // check if custom app is used or app from url
        if($app == null) {

            $this->get_request_app();

        }

        // check if the requested action exists from the current app
        if(file_exists(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'])) . '/src/apps/' . $app . '/controllers/' . $action . '.php') {

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

        // get all files and folders form applications directory
        $apps = scandir('src/apps/');

        // dir navigation into symbols offset starting
        $dir_info = -1;

        // loop through all dir array and remove dir info symbols [ . && .. ]
        foreach($apps as $app) {

            $dir_info++;

            if($app == '.' || $app == '..') {

                unset($apps[$dir_info]);

            }

        }

        // return applications array
        $output = $apps;
        return $output;

    }

    /** 
     * check if the url action parameter was set
     * 
     * @return bool, returns if the action url parameter was set
     * 
    */

    function action_isset() {

        // get request url
        $url = $this->get_url();
            
        // check if action segment was set from url
        if(strlen($url[1]) > 0) {

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

    function get_request_action($default = 'main') {

        // get request url
        $url = $this->get_url();

        // get the requested application action
        if($this->action_isset($url[1])) {

            return $url[1];

        }

        // return default action
        return $default;

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

        // get the config of an application as stdClass
        $config = file_get_contents('src/apps/' . $app . '/config.json');
        $json = json_decode($config);

        // return stdClass array
        return $json;

    }

}
