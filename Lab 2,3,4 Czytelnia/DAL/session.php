<?php

ob_start();
session_start();

include_once "DAL/DBRepository.php";
include_once "DAL/user.php";

class Session{

    public function signIn(User $user){

        if($this->isLoggedIn()){
            $this->logOut();
        }

        $_SESSION['user']['name'] = $user->name;
        $_SESSION['user']['email'] = $user->email;
    }

    public function getUserName(){

        if(isset($_SESSION['user'])){
            return $_SESSION['user']['name'];
        }

        return null;
    }

    public function getUserEmail(){

        if(isset($_SESSION['user'])){
            return $_SESSION['user']['email'];
        }

        return null;
    }

    public function isLoggedIn(){
        return isset($_SESSION['user']);
    }

    public function logOut(){
        unset($_SESSION['user']);
    }

}