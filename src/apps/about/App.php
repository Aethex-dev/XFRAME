<?php

if($_SERVER['REQUEST_METHOD'] == "POST")
    if($_POST['layout'] == "remote") {

        $mvc->parse_page($router->get_request_app(), "Index", "modal");
        return;

}

$mvc->parse_page($router->get_request_app(), "Index", "modal");