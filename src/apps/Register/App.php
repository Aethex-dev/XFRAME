<?php

if(isset($_POST['layout'])) {

    $mvc->parse_page($router->get_request_app(), "Index", "modal");

} else {

$mvc->parse_page($router->get_request_app(), "Index", "main");

}