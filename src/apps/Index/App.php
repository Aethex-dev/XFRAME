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

$db->delete()->table('xe_theme_templates')->where('filename = ? LIMIT 1')->param(array(

    'john'

))->types("s")->execute($conn);

$this->parse_page($this->router->get_request_app(), "Index", "main", array(

    'rows' => $rows

));