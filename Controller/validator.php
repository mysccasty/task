<?php
require_once __DIR__ .'/../Exception/getException.php';
class Validator{
    private $errors;
    private $data=[
        "first_name",
        "surname",
        "place",
        "group_id",
        "mark"
    ];
    private $get = [
        "search",
        "sortedBy",
        "order",
        "last",
        "page"
    ];
    public function getValidate($get){
        foreach($get as $key=>$value){
            if(!in_array($key, $this->get)){
                throw new GetException("Неизвестное поле запроса ".$key);
            }
        }
    }
    public function searchValidate(string $searchQuery){
            if(mb_strlen($searchQuery) === 0){
                throw new getException("Поле поиска не может быть пустым");
            }
            return 0;
    }
    public function sortValidate(string $sortQuery){
        if (!in_array($sortQuery, $this->data)){

            throw new getException("Невозможно упорядочить по полю ".$sortQuery);
        }
        return 0;
    }
    public function pageValidate($page, $count){
        if (!ctype_digit($page)){
            throw new GetException("Порядок страницы может быть только числового типа");
        }
        if (($page<0) || ($page > $count)){
            throw new GetException("Страница не принадлежит диапазону от 0 до ".$count);
        }
    }
    public function formValidate($record){
        $this->errors["first_name"] = $this->validateName($record["first_name"]);
        $this->errors["surname"] = $this->validateSurname($record["surname"]);
        $this->errors["email"] = $this->validateEmail($record["email"]);
        $this->errors["mark"] = $this->validateMark($record["mark"]);
        return array_filter($this->errors, function($value) {
            return $value !== true;
        });
    }
    public function validateName($name){
        $nameLength = mb_strlen($name);
        if (!$nameLength){
            return "Поле имя должно быть заполнено";
        }
        if($nameLength > 255){
            return "Введите более короткое имя";
        }
        return true;
    }
    public function validateSurname($surname){
        $nameLength = mb_strlen($surname);
        if (!$nameLength){
            return "Поле Фамилия должно быть заполнено";
        }
        if($nameLength > 255){
            return "Введите более короткую фамилию";
        }
        return true;
    }
    public function validateEmail($email){
        $emailLength = mb_strlen($email);
        if (!$emailLength){
            return "Поле почта должно быть заполнено";
        }
        else if($emailLength > 255){
            return "Введите более короткую почту";
        }
        return true;
    }
    public function validateMark($mark){
        if (!ctype_digit($mark)){
            return "Поле баллы должно содержать только цифры";
        }
        if (!mb_strlen($mark)){
            return "Поле баллы должно быть заполнено";
        }
        return true;
    }
}