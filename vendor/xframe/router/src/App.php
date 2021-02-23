<?php

namespace xframe\Router;

class App {

    /** 
     * get requested url
     * 
    */

    function get_url() {

        $unparsed = $_SERVER['REQUEST_URI'] ?? '/';

        if($unparsed === '/') {
            $parsed = array('/');
        } else {
            $unparsed = explode("/", $unparsed);
            array_shift($unparsed);
            $parsed = $unparsed;
        }

        return $parsed;

    }

    /** 
     * get requested application
     * 
    */

    function get_request_app() {

        $url = $this->get_url();

        if($url[0] == '/') {
            return 'index';
        } else {
            return $url[0];
        }
        
    }

}
