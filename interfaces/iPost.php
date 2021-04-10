<?php

interface iPost
{
    public function getAllPosts();
    public function getPostById($id);
    public function addPost();
    public function deletePost($image);
}