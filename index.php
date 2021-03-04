<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor/autoload.php';
include 'src/utils.php';

$router = new  \xframe\Router\App();

$apps = $router->get_all_apps();

foreach($apps as $app) {

    $conf = $router->get_app_config($app);
    $conf = json_decode(json_encode($conf), true);

    $app_found = false;

    if($conf['url'] == $router->get_url()[0]) {

        include 'internal_data/cache/themes/Default/templates/' . $router->get_request_app() . '/' . $router->get_request_action('Index.html');
        $app_found = true;
        break;

    }

}

if($app_found == false) {
    echo "The requested page was not found";

}