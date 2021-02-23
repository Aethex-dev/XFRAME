<?php

// dump variable formatted
function dumpf($var = "undefined") {

    echo "<!-- variable dump -->\n <pre>";

    var_dump($var);

    echo "</pre>\n <!-- end variable dump --> ";

}

include 'vendor/autoload.php';

use xframe\Router\App;

$url = new App();

dumpf($url->get_url());