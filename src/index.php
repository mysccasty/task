<?php

require_once __DIR__ .'/../Controller/controller.php';
require_once __DIR__ .'/../Controller/getHandler.php';
$controller = new Controller();
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
if(!$controller->run($_COOKIE['password']??null)){
    $controller->redirect("/auth.php");
}
$marked = [];
$getValidate = [];
foreach($_GET as $key=>$value){
    $getValidate[$key] = htmlspecialchars($value);

}
$getHandler = new GetHandler($getValidate, $controller);
?>
<html>
<head>
    <title>Главная страница</title>
    <script src="./index.js"></script>
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
$getHandler->setLast();
$marked = $getHandler->setSearch();
$getHandler->setSorted();
$getHandler->setPage();
?>
<table>
    <tr>
        <th onclick="sortRequest('<?= http_build_query(array_merge($getValidate, ['sortedBy'=>'first_name']))?>')">Имя</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($getValidate, ['sortedBy'=>'surname']))?>')">Фамилия</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($getValidate, ['sortedBy'=>'place']))?>')">Вуз</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($getValidate, ['sortedBy'=>'group_id']))?>')">Группа</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($getValidate, ['sortedBy'=>'mark']))?>')">Баллы</th>
    </tr>
    <?php echo $controller->render($marked) ?>

</table>
<?php 
    echo $controller->getButtons();
?>
</div>
</body>
</html>