<?php

require_once __DIR__ .'/controller.php';
$controller = new Controller();
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$controller->run($_COOKIE['password']??null);
$marked = [];
?>
<html>
<head>
    <title>Главная страница</title>
    <style>
   .marked {
    background: #ffec82;
    padding: 0 3px;
    border: 1px dashed #333;
   }
  </style>
</head>
<body>
<a href="<?= $controller->getUrl()."/edit.php"?>">Редактировать профиль</a>
<form action="" method="get">
    Поиск:
    <input type="text" id="search" name="search">
    <button type="submit">Найти</button>
</form>
<?php
if (sizeof($_GET)){
    echo "<h4>Результаты поиска по запросу: ".$_GET["search"]."</h4>
    <table>";
    $marked = $controller->search($_GET);
    echo "</table>";
}
?>

<table>
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Вуз</th>
        <th>Группа</th>
        <th>Баллы</th>
    </tr>
    <?php echo $controller->render($marked) ?>

</table>
</body>
</html>