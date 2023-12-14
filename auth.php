<?php
//protectedRoute, gitmerge, gitcherry, gitrebase
require_once __DIR__ .'/Controller/controller.php';
require_once __DIR__.'/src/formData.php';
require_once __DIR__ .'/Controller/validator.php';
$controller = new Controller();
$validate = new Validator();
$password = $_COOKIE['password'] ?? null;
if ($controller->run($password)){
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
$errors = [];
if(sizeof($_POST)){
    $errors = $validate->formValidate($_POST);
    if(empty($errors)){
        $timestamp = time();
        $password = hash('sha256', uniqid(mt_rand(), true));
    
        
        foreach($_POST as $key=>$value){
            $record[$key] = htmlspecialchars($value);
        }
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
}
$replacements = [
    "{{{email}}}" => "Введите почту!",
    "{{{first_name}}}" => "Введите свое имя!",
    "{{{surname}}}" => "Введите свою фамилию!",
    "{{{place}}}" => "Введите свой вуз!",
    "{{{group_id}}}" => "Введите группу!",
    "{{{mark}}}" => "300"
];
foreach($replacements as &$value){
    $value = 'placeholder="'.$value.'"';
}
$replacements["{{{title}}}"] = "Форма регистрации";
$replacements["{{{method}}}"] = $_SERVER['PHP_SELF'];
$replacements["{{{gender}}}"] = gender;
$replacements["{{{home}}}"] = "";
$replacements["{{{head}}}"] = "Для доступа пройдите регистрацию";
$replacements["{{{button}}}"] = "Зарегистрироваться!";
foreach($_POST as $key => $value){
    if($key === "gender") continue;
    $replacements["{{{".$key."}}}"] .= "value='$value'";
}
foreach($errors as $key=>$value){
    $replacements["{{{".$key."}}}"] .= "><p style='color: red;'>".$value."</p";
}
echo str_replace(array_keys($replacements), array_values($replacements),form);

