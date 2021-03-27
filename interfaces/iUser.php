<?php

interface iUser
{
    public function getAllUsers();
    public function getUserById();
    public function addUser();
    public function deleteUser();
}