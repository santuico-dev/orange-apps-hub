<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interface\PostInterface;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostInterface
{

    public function fetchAllPost()
    {
        //all post
        $posts = Post::join('users', 'users.id', '=', 'post.user_id')
            ->select(
                'post.id',
                'post.post_content',
                'post.media_type',
                'post.post_media_path',
                'post.post_like_count',
                'post.post_comment_count',
                'post.post_created_at',
                'users.id as user_id',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'users.user_profile_image as user_profile_image'
            )
            ->orderBy('post.created_at', 'desc')
            ->get();

        //getting all the posts that the curr user liked
        $currUserLikedPostsIDs = DB::table('post_likes')
            ->where('user_id', auth()->user()->id)
            ->pluck('post_id')
            ->toArray();

        //adding the liked field in the posts result
        foreach ($posts as $post) {
            $post->liked = in_array($post->id, $currUserLikedPostsIDs);
        }

        return $posts;
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
