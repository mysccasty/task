<?php
#require_once __DIR__ .'/student.php';
require_once __DIR__ .'/controller.php';
$timestamp = time();
$password = hash('sha256', uniqid(mt_rand(), true));

$record = $_POST;
$record['timestamp'] = $timestamp;
$expires = strtotime("+10 years", $timestamp);
$record['password'] = $password;
$controller = new Controller();
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

if ($controller->setNewUser($record)){
    setcookie("password", $password, $expires);
    header("Location: ".$url."/index.php");
}
else {
    echo "Пиздец";
}
