<?php

interface iFollower
{
    public function getAllFollowers();
    public static function getFollowerbyId();
    public function addFollower();
    public function deleteFollower();
}