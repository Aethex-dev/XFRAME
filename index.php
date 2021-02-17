<?php

define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

// setup composer autoloader
require_once __ROOT__ . '/vendor/autoload.php';

class App {

    function say_hi($text) {

        return "Hello " . $text;

    }

}

$jack = new App();

echo $jack->say_hi('xfaon');