<?php

require_once __DIR__ .'/controller.php';
if (sizeof($_COOKIE)){
    $controller = new Controller();
    $controller->run($_COOKIE['password']??null);
}

else{
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    header("Location: ".$url."/formData.php?auth=1");
    die();
}
?>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
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