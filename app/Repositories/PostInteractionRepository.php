<?php

namespace App\Repositories;

use App\Models\PostInteraction;
use App\Models\PostLike;
use App\Repositories\Interface\PostInteractionInterface;
use Illuminate\Support\Facades\DB;

class PostInteractionRepository implements PostInteractionInterface
{

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

    public function togglePostLike($postID, $userID)
    {
        $like =  PostLike::where('user_id', $userID)
            ->where('post_id', $postID)
            ->first();

        //checks if the user already liked the post, if the user clicked like again, it will unlike the post therefore removing the interaction
        if ($like) {
            $like->delete();

            return false;
        } else {

            //create a interaction data of like
            PostLike::create([
                'user_id' => $userID,
                'post_id' => $postID
            ]);

            return true;
        }
    }

    public function createPostComment($commentData): ?PostInteraction
    {
        return PostInteraction::create($commentData);
    }
}
