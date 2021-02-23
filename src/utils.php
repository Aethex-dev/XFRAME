<?php

// dump variable formatted
function dumpf($var = "undefined") {

    echo "<!-- variable dump -->\n <pre>";

    var_dump($var);

    echo "</pre>\n <!-- end variable dump --> ";

}