<?php

require_once __DIR__ .'/controller.php';
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
   /*#table {
    width: 64%;
    height: 50%;
    border: 2px solid red;
    border-radius: 12px;
    margin-left: auto;
    margin-right: auto;
    transform: translate(0);
   }*/
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
if (isset($getValidate["last"])){
    $controller->setlastId($getValidate["last"]);
}
if (isset($getValidate["search"])){
    $hide = "style='display: none;'";
    $message = "Показать таблицу";
    if(isset($getValidate["sortedBy"]) || isset($getValidate["page"])){
        $hide = "";
        $message = "Скрыть таблицу";
    }
    echo "<h4>Результаты поиска по запросу: ".$getValidate["search"]."</h4>
    <table>";
    $marked = $controller->search($getValidate);
    echo "</table>";
    echo "<input type='button' id='hide' onclick='showtable()' value='{$message}'/>";
}
if (isset($getValidate["sortedBy"])){
    if (isset($getValidate["order"])){
        
        $controller->setOrder($getValidate["order"]);
    }
    $controller->setSort($getValidate["sortedBy"]);
}
if (isset($getValidate["page"])){
    $controller->setPage($getValidate["page"]);
}


?>
<div id="hidetable" <?php echo $hide ?? "" ?>>
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
<script>
    function sortRequest(url){
        const paramsString = document.location.search;
        const searchParams = new URLSearchParams(paramsString);
        const urlParams = new URLSearchParams(url);

        if (urlParams.get("sortedBy") === searchParams.get("sortedBy") && searchParams.get("order") !== "1"){
            urlParams.set('order','1');
        }
        else {
            urlParams.delete('page');
            urlParams.delete('order');
        }
        window.location.search = urlParams;
    }
    function pagination(page, mode){
        const url = document.location.search;
        const urlParams = new URLSearchParams(url);
        if (mode==="next"){
            urlParams.set('page', Number(page)+1);
        }
        else {
            urlParams.set('page', Number(page)-1);
        }
        window.location.search = urlParams;
    }
    function showtable() {
        const table = document.getElementById("hidetable");
        const showButton = document.getElementById("hide");
        if (table.style.display === "none") {
            table.style.display = "";
            showButton.value = "Скрыть таблицу";
        } else {
        table.style.display = "none";
        showButton.value = "Показать таблицу";
    }
}
</script>
</html>