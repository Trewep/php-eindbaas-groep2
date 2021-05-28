<?php

interface iLike
{
    public static  function getLikesByPostId($postId);
    public function addLike();
    public function deleteLike();
}