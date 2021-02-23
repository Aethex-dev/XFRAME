<?php

namespace xframe\Router;

class App {

    // get requested url
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

}
