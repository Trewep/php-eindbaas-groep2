<?php

interface iUser
{
    public function getAllUsers();
    public  function getUserById();
    static function register($username, $email, $firstName, $lastName, $password, $passwordVerify, $date);
}