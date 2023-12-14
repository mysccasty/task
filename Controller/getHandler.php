<?php
require_once __DIR__ .'/validator.php';
class GetHandler{

    private $getQuery;
    private $controller;
    private $errorHandler;
    private $errors = [];
    public function __construct(?Array $getQuery, Controller $controller){
        $this->getQuery = $getQuery;
        $this->controller = $controller;
        $this->errorHandler = new Validator();
    }
    public function setLast(){
        if (isset($this->getQuery["last"])){

            $this->controller->setlastId($this->getQuery["last"]);
        }
    }
    public function setPage(){
        if (isset($this->getQuery["page"])){
            $countPages = ceil($this->controller->getCount()/$this->controller->getOffset())-1;
            $this->errorHandler->pageValidate($this->getQuery["page"], $countPages);
            $this->controller->setPage($this->getQuery["page"]);
        }
    }
    public function setSorted(){
        if (isset($this->getQuery["sortedBy"])){
            $this->errorHandler->sortValidate($this->getQuery["sortedBy"]);
            if (isset($this->getQuery["order"])){
                
                $this->controller->setOrder($this->getQuery["order"]);
            }
            $this->controller->setSort($this->getQuery["sortedBy"]);
        }
    }
    public function setSearch(){
        if (isset($this->getQuery["search"])){
            $this->errorHandler->searchValidate($this->getQuery["search"]);
            return 1;
        }
    }
    public function show(){
        $hide = "style='display: none;'";
        $message = "Показать таблицу";
        if(isset($this->getQuery["sortedBy"]) || isset($this->getQuery["page"])){
            $hide = "";
            $message = "Скрыть таблицу";
        }
        echo "<h4>Результаты поиска по запросу: ".$this->getQuery["search"]."</h4>
        <table>";
        $marked = $this->controller->search($this->getQuery);
        echo "</table>";
        echo "<input type='button' id='hide' onclick='showtable()' value='{$message}'/>";
        echo '<div id="hidetable" '.$hide.'>';
        return $marked;
    }
    public function getHandle(){
        try{
            $this->errorHandler->getValidate($this->getQuery);
        }
        catch(GetException $e){
            array_push($this->errors,$e->getMessage());
        }
        $this->setLast();
        try{
            $show = $this->setSearch();
        }
        catch(GetException $e){
            array_push($this->errors,$e->getMessage());
        }
        try{
            $this->setPage();
        }
        catch(GetException $e){
            array_push($this->errors, $e->getMessage());
        }
        try{
            $this->setSorted();
        }
        catch(GetException $e){
            array_push($this->errors,$e->getMessage());
        }
        foreach($this->errors as $key){
            echo "<div>".$key."</div>";
            die();
        }
        if ($show){
            $marked = $this->show();
            return $marked;
        }
        return [];
    }
}