<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interface\PostInterface;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostInterface
{

    public function fetchAllPost()
    {
        return Post::join('users', 'users.id', '=', 'post.user_id')
            ->select(
                'post.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'users.email as user_email'
            )
            ->get();
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
