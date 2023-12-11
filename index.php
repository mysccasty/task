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
if (isset($_GET["sortedBy"])){
    if (isset($_GET["order"])){
        
        $controller->setOrder($_GET["order"]);
    }
    $controller->setSort($_GET["sortedBy"]);
}
if (isset($_GET["search"])){
    echo "<h4>Результаты поиска по запросу: ".$_GET["search"]."</h4>
    <table>";
    $marked = $controller->search($_GET);
    echo "</table>";
}

?>

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
            urlParams.delete('order');
        }
        window.location.href = "?"+urlParams;
    }
</script>
</html>