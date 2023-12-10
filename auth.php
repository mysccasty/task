<?php
require_once __DIR__ .'/controller.php';
require_once __DIR__.'/formData.php';
$controller = new Controller();
if ($controller->run($_COOKIE['password'])){
    $controller->redirect("/index.php");
}
const gender = <<<HTML
        <p>Пол</p>
            <input type="radio" id="male" name="gender" value="муж" checked/>
            <label for="male">Мужской</label>
            <br>
            <input type="radio" id="female" name="gender" value="жен" {{{gender}}}/>
            <label for="male">Женский</label>
HTML;
if(sizeof($_POST)){
    $timestamp = time();
    $password = hash('sha256', uniqid(mt_rand(), true));

    $record = $_POST;
    $record['timestamp'] = $timestamp;
    $expires = strtotime("+10 years", $timestamp);
    $record['password'] = $password;
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

    if ($controller->setNewUser($record)){
        setcookie("password", $password, $expires);
        header("Location: ".$url."/index.php");
    }
    else {
        echo "Не пошло";
    }
}
$replacements = [
    "{{{title}}}" => "Форма регистрации",
    "{{{method}}}" => $_SERVER['PHP_SELF'],
    "{{{head}}}" => "Для доступа пройдите регистрацию",
    "{{{email}}}" => "Введите почту!",
    "{{{first_name}}}" => "Введите свое имя!",
    "{{{gender}}}" => gender,
    "{{{surname}}}" => "Введите свою фамилию!",
    "{{{place}}}" => "Введите свой вуз!",
    "{{{group_id}}}" => "Введите группу!",
    "{{{mark}}}" => "300",
    "{{{button}}}" => "Зарегистрироваться!"

];
echo str_replace(array_keys($replacements), array_values($replacements),form);

