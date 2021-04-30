<?php

interface iPost
{
    public function getAllPosts();
    public function getPostById();
    public function addPost();
    public function deletePost($image);
}