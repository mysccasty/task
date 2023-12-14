<?php
require_once __DIR__ .'/Controller/controller.php';
require_once __DIR__.'/src/formData.php';
require_once __DIR__ .'/Controller/validator.php';
$controller = new Controller();
$validate = new Validator();
$record = $controller->find("password", $_COOKIE["password"])[0];
$input = $_POST;
$errors = [];
if(sizeof($_POST)){
    $errors = $validate->formValidate($_POST);
    if(empty($errors)){
        foreach($input as $key=>$value){
            if ($value == $record[$key]){
                unset($input[$key]);
            }
        }
        foreach($input as &$value){
            $value = htmlspecialchars($value);
        }
        if($controller->editUser($input, $_COOKIE["password"]));
    }
}
foreach($record as &$value){
    $value = "value=".$value;
}
$replacements = [
    "{{{title}}}" => "Редактирование профиля",
    "{{{home}}}" => '<a href='.$controller->getUrl().'/index.php
    <i class="fa fa-home fa-fw"></i>Домой</a>',
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
foreach($errors as $key=>$value){
    $replacements["{{{".$key."}}}"] .= "><p style='color: red;'>".$value."</p";
}
echo str_replace(array_keys($replacements), array_values($replacements),form);


