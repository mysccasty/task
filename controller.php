<?php
require_once __DIR__ .'/model.php';
require_once __DIR__ .'/viewer.php';
require_once __DIR__ .'/Student.php';

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
    public function __construct(){
        $this->db = new Model($this->dbinfo);
        $this->url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    }
    public function render():string{
        
        $records = $this->db->allStudents();
        $view = new Viewer();
            return $view->render($records);

    }
    public function run(?string $password){
        if (!$password){
            $this->redirect("/auth.php");
        }
        $data = $this->search("password", $password);
        if(sizeof($data)){
            return;

        }
        $this->redirect("/auth.php");
    }
    public function search(string $field, string $value){
        return $this->db->search($field, $value);
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
}