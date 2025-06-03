<?php

namespace App\Repositories\Interface;

interface PostInteractionInterface {

    public function fetchPostCommentsByPostID($postID);

    public function createPostComment($commentData);

    public function togglePostLike($postID, $userID);

}
