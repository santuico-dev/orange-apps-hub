<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interface\PostInterface;

class PostRepository implements PostInterface
{

    public function fetchAllPost()
    {
        return null;
    }

    public function fetchPostByUserID($userID): ?Post
    {
        return Post::where('user_id', $userID)->first();
    }

    public function fetchPostByPostID($postID): ?Post
    {
        return Post::where('id', $postID)->first();
    }

    public function createPost($postData): ?Post
    {
        return Post::create($postData);
    }

    public function updatePost($postID, $postData)
    {
        return Post::where('id', $postID)->update($postData);
    }

    public function deletePost($postID)
    {
        return Post::where('id', $postID)->delete();
    }
}
