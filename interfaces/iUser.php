<?php

interface iUser
{
    public function getAllUsers();
    public function getUserById(int $id);
    public function addUser();
    public function deleteUser();
}