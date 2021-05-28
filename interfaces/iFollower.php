<?php

interface iFollower
{
    public function getFollowerByUserId();
    public function addFollower();
    public function deleteFollower();
}