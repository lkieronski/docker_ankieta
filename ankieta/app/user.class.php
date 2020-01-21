<?php
class User{
    public $login;
    public $pass;

    function __construct($login, $pass){
        $this->login = $login;
        $this->pass = $pass;
    }
}
?>