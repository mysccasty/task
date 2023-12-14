<?php
require_once __DIR__ .'/../Model/model.php';
require_once __DIR__ .'/../View/view.php';
require_once __DIR__ .'/../Model/Student.php';

class Controller{
    private $db;
    private $dbinfo = [
        "host"=> "localhost",
        "dbname"=> "students_db",
        "charset"=> "utf8mb4",
        "login"=>"root",
        "password"=> ""
    ];
    private $url;
    private $view;
    private $sort;
    private $order;
    private $offset = 5;
    private $page = 0;
    private $count;
    public function __construct(){
        $this->db = new Model($this->dbinfo);
        $this->view = new View();
        $this->url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $this->setCount();
    }
    public function setSort(String $col){
        $this->sort = $col;
    }
    public function setOrder(String $order){
        $this->order = $order;
    }
    public function getUrl(){
        return $this->url;
    }
    public function setCount(){
        $this->count = $this->db->getLength();
    }
    public function getCount(){
        return $this->count;
    }
    public function getOffset(){
        return $this->offset;
    }
    public function setlastId($lastId){
        $this->lastId = $lastId;
    }
    public function setPage($page){
        $this->page = $page;
    }
    public function getButtons(){
        $buttons = "";
        if ($this->page-1>=0){
            $buttons.="<button onclick='pagination({$this->page}, \"back\")'>prev</button>";
        }
        for($i = 1; $i <= ceil($this->count/$this->offset); $i++){
            $buttons.="<button onclick='pagination({$i}, \"go\")'>$i</button>";
        }
        if(($this->page+1)*$this->offset-$this->count<0){
            $buttons.="<button onclick='pagination({$this->page}, \"next\")'>next</button>";
        }
        return $buttons;
    }
    public function render(?Array $marked):string{
        $records = $this->db->allStudents($this->sort, $this->order, $this->offset*$this->page, $this->offset); 
        return $this->view->render($records, $marked);

    }
    public function run(?string $password){
        if ($password){
            $data = $this->find("password", $password);
            if(sizeof($data)){
                return 1;
    
            }
        }

        return 0;
    }
    public function find(string $field, string $value){
        return $this->db->find($field, $value);
    }
    public function redirect(string $script){
        header("Location: ".$this->url.$script);
        die();
    }
    public function setNewUser(array $data){
        $record = new Student();
        $record->setRecord($data);
        return $this->db->postRecord($record);
    }
    public function editUser(array $data, string $password){
        $this->db->editStudent($data, $password);
        
        $this->redirect("/index.php");
    }
    public function search(?array $request){
        $queryList = explode(" ", $request['search']);
        $renderedString = "";
        $forRender = [];
        foreach($queryList as $key){
            $result = $this->db->search("%".trim($key, "\n\r\t,.")."%");
            $forRender = array_merge($forRender, $result);
        }
        $forRender = array_unique($forRender);
        if (empty($forRender)){
            echo "По вашему запросу ничего не найдено";
            return [];
        }
        foreach($forRender as $key){
            $renderedString.=$this->view->render($this->db->findWithId($key));
        }
        echo $renderedString;

        return $forRender;

    }
}