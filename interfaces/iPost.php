<?php

interface iPost
{
    public function addPost();
    public function deletePost();
    public function getPostsByLocation($location);
    public function getPostsByTag();
}