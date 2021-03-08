<?php

$db = new \xframe\Database\App();

$conn = $db->connect(array(

    'host' => "localhost",
    'username' => "root",
    'password' => '', 
    'database' => 'xframe'

));

$db->select()->table('xe_theme_templates')->column('*')->execute($conn);

$rows = array();

while($row = $db->fetch()) {

    array_push($rows, $row['filename']);

}

$this->parse_page($this->router->get_request_app(), "Index", "main", array(

    'rows' => $rows

));