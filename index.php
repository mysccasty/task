<?php

require_once __DIR__ .'/controller.php';
$controller = new Controller();
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$controller->run($_COOKIE['password']??null);
$marked = [];
echo $url.$_SERVER["QUERY_STRING"];
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
if (isset($_GET["last"])){
    $controller->setlastId($_GET["last"]);
}
if (isset($_GET["search"])){
    $hide = "style='display: none;'";
    $message = "Показать таблицу";
    if(isset($_GET["sortedBy"]) || isset($_GET["page"])){
        $hide = "";
        $message = "Скрыть таблицу";
    }
    echo "<h4>Результаты поиска по запросу: ".$_GET["search"]."</h4>
    <table>";
    $marked = $controller->search($_GET);
    echo "</table>";
    echo "<input type='button' id='hide' onclick='showtable()' value='{$message}'/>";
}
if (isset($_GET["sortedBy"])){
    if (isset($_GET["order"])){
        
        $controller->setOrder($_GET["order"]);
    }
    $controller->setSort($_GET["sortedBy"]);
}
if (isset($_GET["page"])){
    $controller->setPage($_GET["page"]);
}


?>
<div id="hidetable" <?php echo $hide ?? "" ?>>
<table>
    <tr>
        <th onclick="sortRequest('<?= http_build_query(array_merge($_GET, ['sortedBy'=>'first_name']))?>')">Имя</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($_GET, ['sortedBy'=>'surname']))?>')">Фамилия</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($_GET, ['sortedBy'=>'place']))?>')">Вуз</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($_GET, ['sortedBy'=>'group_id']))?>')">Группа</th>
        <th onclick="sortRequest('<?= http_build_query(array_merge($_GET, ['sortedBy'=>'mark']))?>')">Баллы</th>
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
        let paramsString = document.location.search;
        let searchParams = new URLSearchParams(paramsString);
        let urlParams = new URLSearchParams(url);
        if (urlParams.get("sortedBy") === searchParams.get("sortedBy") && searchParams.get("order") !== "1"){
            urlParams.set('order','1');
        }
        else {
            urlParams.delete('page');
            urlParams.delete('order');
        }
        window.location.href = "?"+urlParams;
    }
    function pagination(page, mode){
        let url = document.location.search;
        let urlParams = new URLSearchParams(url);
        if (mode==="next"){
            urlParams.set('page', Number(page)+1);
        }
        else {
            urlParams.set('page', Number(page)-1);
        }
        window.location.href = "?" + urlParams;
    }
    function showtable() {
        let table = document.getElementById("hidetable");
        let showButton = document.getElementById("hide");
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