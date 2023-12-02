<?php
class Student{
    private $first_name;
    private $surname;
    private $gender;
    private $email;
    private $password;
    private $place;
    private $group_id;
    private $mark;
    private $timestamp;
    private $student_id;
    public function __construct(){
    }
    public function setRecord(array $record){
        foreach($record as $key => $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }
    public function get_first_name(){
        return $this->first_name;
    }
    public function get_surname(){
        return $this->surname;
    }
    public function get_gender(){
        return $this->gender;
    }
    public function get_email(){
        return $this->email;
    }
    public function get_password(){
        return $this->password;
    }
    public function get_place(){
        return $this->place;
    }
    public function get_group_id(){
        return $this->group_id;
    }
    public function get_mark(){
        return $this->mark;
    }
    public function get_timestamp(){
        return $this->timestamp;
    }
    public function get_student_id(){
        return $this->student_id;
    }

    public function set_first_name(){
        return $this->first_name;
    }
    public function set_surname(string $surname){
        $this->surname=$surname;
    }
    public function set_gender(string $gender){
        $this->gender=$gender;
    }
    public function set_email(string $email){
        $this->email=$email;
    }
    public function set_password(string $password){
        $this->password=$password;
    }
    public function set_place(string $place){
        $this->place=$place;
    }
    public function set_group_id(string $group_id){
        $this->group_id=$group_id;
    }
    public function set_mark(string $mark){
        $this->mark=$mark;
    }
    public function set_timestamp(int $timestamp){
        $this->timestamp=$timestamp;
    }
}