<?php

namespace xframe\Router;

class App {

    // get requested url
    function get_url():array {

        $unparsed = $_SERVER['REQUEST_URI'] ?? '/';

        if($unparsed === '/') {

            $parsed = array('/');

        } else {

            $parsed = $unparsed;

        }

        return $parsed;

    }

}
