<?php

include 'vendor/autoload.php';
include 'src/utils.php';

$db = new \xframe\Database\App();

$conn = $db->connect(array(

    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'xframe',
    'port' => 3306,
    'charset' => 'utf8'

));

$db->update()->set('filename = ?')->types("ss")->table("xe_theme_templates")->where('filename = ?')->param(array(

    'john',
    'jack'

))->execute($conn);

$db->select()->column("*")->table("xe_theme_templates")->execute($conn);

while($row = $db->fetch()) {

    echo "filename: " . $row['filename'] . "<br>";

}