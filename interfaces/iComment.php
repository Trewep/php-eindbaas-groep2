<?php

interface iUser
{
    public function getAllComments();
    public function getCommentById();
    public function addComment();
    public function deleteComment();
}