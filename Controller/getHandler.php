<?php

class GetHandler{

    private $getQuery;
    private $controller;
    public function __construct(?Array $getQuery, Controller $controller){
        $this->getQuery = $getQuery;
        $this->controller = $controller;
    }
    public function setLast(){
        if (isset($this->getQuery["last"])){
            $this->controller->setlastId($this->getQuery["last"]);
        }
    }
    public function setPage(){
        if (isset($this->getQuery["page"])){
            $this->controller->setPage($this->getQuery["page"]);
        }
    }
    public function setSorted(){
        if (isset($this->getQuery["sortedBy"])){
            if (isset($this->getQuery["order"])){
                
                $this->controller->setOrder($this->getQuery["order"]);
            }
            $this->controller->setSort($this->getQuery["sortedBy"]);
        }
    }
    public function setSearch(){
        $marked =[];
        if (isset($this->getQuery["search"])){
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
        }
        return $marked;
    }
}