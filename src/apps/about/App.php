<?php

if(isset($_POST['layout'])) {

        echo $_COOKIE['xe_theme'];
        $this->parse_page($this->router->get_request_app(), "Index", "modal");

} else {

$this->parse_page($this->router->get_request_app(), "Index", "main");

}