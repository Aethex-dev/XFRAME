<?php

/** 
 * FILENAME: utils.php
 * DESCRIPTION: holds functions for framework utilities
 * AUTHORS: XENONMC XFRAME
*/

/** 
 * dump formatted variable as json
 * 
 * @param array or variable to convert to json and render in a formatted layout
 * 
*/

function dumpf($var = "undefined") {

    echo "<!-- variable dump -->\n <pre>";

    var_dump($var);

    echo "</pre>\n <!-- end variable dump --> ";

}