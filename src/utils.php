<?php

/** 
 * FILENAME: utils.php
 * DESCRIPTION: holds functions for framework utilities
 * AUTHORS: XENONMC XFRAME
 * 
 */

/** 
 * dump formatted variable as json
 * 
 * @param array/string, convert to json and render in a formatted layout
 * 
 */

function dumpf($var = "undefined")
{

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

function cout($text)
{

    echo '<script>';
    echo 'console.log(' . $text . ');';
    echo '</script>';
}

/** 
 * display a formatted error
 * 
 * @param string, error text
 * 
 */

function error($text, $isFatal = false)
{

    if ($isFatal == true) {

        die("<p style = 'font-family: sans-serif; font-size: 13px;'><strong>FATAL ERROR: " . $text . "</strong></p>\n");
        return;
    }

    echo "<p style = 'font-family: sans-serif; font-size: 13px;'><strong>ERROR: " . $text . "</strong></p>\n";
}

/** 
 * redirect user
 * 
 * @param string, location
 * 
 */

function redirect($location)
{

    echo "<script> window.location.href = '" . $location . "'; </script>";
}

/** 
 * process errors
 * 
 * @param array, array of errors
 * 
 */

function process_errors(array $errors)
{

    $errors_json = json_encode($errors);
    echo $errors_json;
}

/** 
 * reload page
 * 
 */

function reload()
{

    echo "<script>location.reload();</script>";
}
