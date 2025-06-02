<?php

namespace App\Repositories\Interface;

interface PostInterface {

    public function fetchAllPost();
    public function fetchPostByUserID($userID);
    public function fetchPostByPostID($postID);

    public function createPost($postData);
    public function updatePost($postID, $postData);
    public function deletePost($postID);

}
