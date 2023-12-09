<?php

require_once __DIR__ .'/controller.php';
$str = "asd,";
$controller = new Controller();
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$controller->run($_COOKIE['password']??null, $url);
?>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
<a href="<?= $url."/edit.php"?>">Редактировать профиль</a>
<table>
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Вуз</th>
        <th>Группа</th>
        <th>Баллы</th>
    </tr>
    <?php echo $controller->render() ?>

</table>
</body>
</html>