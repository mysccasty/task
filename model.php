<?php
require_once __DIR__ .'/Student.php';

class Model{
    private $pdo;
    public function __construct(array $dbinfo){

        $this->pdo = new PDO(
            "mysql:host={$dbinfo['host']};
            dbname={$dbinfo['dbname']};
            charset={$dbinfo['charset']}",
            $dbinfo["login"],
            $dbinfo["password"]);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function postRecord(Student $student){
        
        $query = $this->pdo->prepare("INSERT INTO students VALUES(
            :first_name,
            :surname,
            :gender,
            :place,
            :group_id,
            :mark,
            :email,
            :password,
            :timestamp,
            :student_id)");
        $query->bindValue(':first_name',$student->get_first_name());
        $query->bindValue(':surname',$student->get_surname());
        $query->bindValue(':gender',$student->get_gender());
        $query->bindValue(':place',$student->get_place());
        $query->bindValue(':group_id',$student->get_group_id());
        $query->bindValue(':mark',$student->get_mark());
        $query->bindValue(':email',$student->get_email());
        $query->bindValue(':password',$student->get_password());
        $query->bindValue(':timestamp',$student->get_timestamp());
        $query->bindValue(':student_id',$student->get_student_id());
        return $query->execute();
        
    }
    public function auth(string $password){
        $query = $this->pdo->prepare('SELECT * FROM students WHERE password=:password');
        $query->bindValue(':password',$password);
        return $query->fetchAll(PDO::FETCH_CLASS,'Student');
        
    }
    public function allStudents(){
        $query = $this->pdo->prepare("SELECT first_name, surname, place, group_id, mark from students");
        return $query->fetchAll(PDO::FETCH_CLASS,"Student");
    }

}