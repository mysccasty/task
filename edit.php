<?php
require_once __DIR__ .'/controller.php';
require_once __DIR__.'/formData.php';
$controller = new Controller();
$record = $controller->find("password", $_COOKIE["password"])[0];
$input = $_POST;
if(sizeof($_POST)){
    foreach($input as $key=>$value){
        if ($value == $record[$key]){
            unset($input[$key]);
        }
    }
    if($controller->editUser($input, $_COOKIE["password"]));
}
$replacements = [
    "{{{title}}}" => "Редактирование профиля",
    "{{{method}}}" => $_SERVER['PHP_SELF'],
    "{{{head}}}" => "Редактирование профиля",
    "{{{email}}}" => $record["email"],
    "{{{first_name}}}" => $record["first_name"],
    "{{{surname}}}" => $record["surname"],
    "{{{gender}}}" => "",
    "{{{place}}}" => $record["place"],
    "{{{group_id}}}" => $record["group_id"],
    "{{{mark}}}" => $record["mark"],
    "{{{button}}}" => "Сохранить изменения!"

];

echo str_replace(array_keys($replacements), array_values($replacements),form);


