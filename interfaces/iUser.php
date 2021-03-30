<?php

interface iUser
{
    public function getAllUsers();
    public static function getUserById(int $id);
    public function addUser();
    public function deleteUser();
}