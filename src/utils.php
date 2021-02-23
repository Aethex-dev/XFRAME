<?php

/** 
 * FILENAME: utils.php
 * DESCRIPTION: holds functions for framework utilities
 * AUTHORS: XENONMC XFRAME
*/

/** 
 * dump formatted variable as json
 * 
 * @param array/string, convert to json and render in a formatted layout
 * 
*/

function dumpf($var = "undefined") {
    echo "<!-- variable dump -->\n <pre>";
    var_dump($var);
    echo "</pre>\n <!-- end variable dump -->";
}

/** 
 * log to the browsers console
 * 
 * @param string, the text you want to log to the console
 * 
*/

function cout($text) {
    echo '<script>';
    echo 'console.log(' . $text . ');';
    echo '</script>';
}

/** 
 * display a formated error
 * 
 * @param string, error text
 * 
*/

function error($text) {

    echo "<p style = 'font-family: sans-serif; font-size: 13px;'><strong><i>ERROR: " . $text . "</i></strong></p>";
    
}