<?php


class User{

    public $email, $name, $password;

    function __construct($email, $name, $password){
        $this->email = $email;
        $this->name = $name;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

}