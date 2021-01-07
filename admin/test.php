<?php 
require_once '../config/database.php';
require_once '../config/config.php';
spl_autoload_register(function ($className) {
    require '../app/models/' . $className . '.php';
});

$UserModel = new UserModel();
$userList = $UserModel->getAllUser();

foreach ($userList as  $value) {
    echo $value['user_pass'].'<br>';
}
echo hash('md5','12345');