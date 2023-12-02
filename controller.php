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
    public function __construct(){
        $this->db = new Model($this->dbinfo);
    }
    public function render():string{
        
        $records = $this->db->allStudents();
        echo "<pre>";
        print_r($records);
        echo "</pre>";
        $str = "";
        $view = new Viewer($this->db);
        $str.= $view->render();
        return $str;

    }
    public function run(?string $password){
        /*if (!$password){
            echo "ABOBA";
            exit();
        }
        $data = $this->db->auth($password);*/
    }
    public function setNewUser(array $data){
        $record = new Student();
        $record->setRecord($data);
        return $this->db->postRecord($record);
    }
}