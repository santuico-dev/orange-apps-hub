<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interface\PostInterface;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostInterface
{

    public function fetchAllPost()
    {
        //fetch post media and user
        $posts = Post::with(['media', 'user'])
            ->orderBy('post_created_at', 'desc')
            ->get();

        //id of the post that the curr user liked
        $likedPostIDs = DB::table('post_likes')
            ->where('user_id', auth()->user()->id)
            ->pluck('post_id')
            ->toArray();

        //combined data of the post
        $allPost = $posts->map(function ($post) use ($likedPostIDs) {
            return [
                'id' => $post->id,
                'post_content' => $post->post_content,
                'post_like_count' => $post->post_like_count,
                'post_comment_count' => $post->post_comment_count,
                'post_created_at' => $post->post_created_at,
                'liked' => in_array($post->id, $likedPostIDs),
                'user_id' => $post->user->id,
                'user_full_name' => $post->user->first_name . ' ' . $post->user->last_name,
                'user_profile_image' => $post->user->user_profile_image,
                'media' => $post->media->map(function ($media) {
                    return [
                        'media_path' => $media->media_path,
                        'media_type' => $media->media_type,
                    ];
                }),
            ];
        });

        return $allPost;
    }


    public function fetchPostByUserID($userID): ?Post
    {
        return Post::where('user_id', $userID)->get();
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
