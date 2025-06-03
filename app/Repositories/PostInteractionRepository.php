<?php

namespace App\Repositories;

use App\Models\PostInteraction;
use App\Repositories\Interface\PostInteractionInterface;
use Illuminate\Support\Facades\DB;

class PostInteractionRepository implements PostInteractionInterface
{

    public function createPostComment($commentData): ?PostInteraction
    {
        return PostInteraction::create($commentData);
    }

    public function fetchPostCommentsByPostID($postID)
    {
        return PostInteraction::join('users', 'users.id', '=', 'comments.user_id')
            ->select(
                'comments.user_id',
                'comments.post_id',
                'comments.comment_content',
                'users.user_profile_image as user_profile_image',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'comments.comment_created_at as comment_date'
            )
            ->where('post_id', $postID)
            ->orderBy('comments.comment_created_at', 'desc')
            ->get();
    }
}
