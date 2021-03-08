<?php

// ini set
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor/autoload.php';
include 'src/utils.php';

$mvc = new \xframe\Mvc\App();

$router = new  \xframe\Router\App();

$apps = $router->get_all_apps();

foreach($apps as $app) {

    $conf = $router->get_app_config($app);
    $conf = json_decode(json_encode($conf), true);

    $app_found = false;
    $url = $router->get_url();

    if(strcasecmp($conf['url'], $url[0]) == 0) {

        if($url[1] != "") {

            $path = 'src/apps/' . $router->get_request_app() . '/controllers/' . $url[1] .'.php';

            if(file_exists($path)) {

                include $path;

            } else {

                echo "error 404";

            }

        } else {

            $path = 'src/apps/' . $router->get_request_app() . '/App.php';

            include $path;

        }

        $app_found = true;
        break;

    }

}

if($app_found == false) {

    echo "The requested page was not found";

}