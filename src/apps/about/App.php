<?php

if(isset($_POST['layout'])) {

        echo $_COOKIE['xe_theme'];
        $mvc->parse_page($router->get_request_app(), "Index", "modal");

} else {

$mvc->parse_page($router->get_request_app(), "Index", "main");

}