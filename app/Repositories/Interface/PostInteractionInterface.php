<?php

namespace App\Repositories\Interface;

interface PostInteractionInterface {

    public function createPostComment($commentData);
    public function likePost($postID, $userID);
}
