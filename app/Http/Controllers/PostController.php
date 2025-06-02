<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function fetchAllPost()
    {
        try {

            return $this->postRepository->fetchAllPost();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function fetchPostByPostID($postID)
    {
        try {

            if(!$this->postRepository->fetchPostByPostID($postID)) {
                return response()->json(['message'=> 'Post not found'], 404);
            }

            return $this->postRepository->fetchPostByPostID($postID);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

        public function fetchPostByUserID($userID)
    {
        try {

            if(!$this->postRepository->fetchPostByUserID($userID)) {
                return response()->json(['message'=> 'User not found'], 404);
            }

            return $this->postRepository->fetchPostByUserID($userID);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function createPost(Request $request)
    {
        try {

            $mediaType = null;
            $mediaPath = null;

            $validatedPostReq = $request->validate(
                [
                    'post_content' => 'required|string',
                    'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480', //i set this to 20mb
                    'post_comment_count' => 'nullable|integer|min:0',
                    'post_like_count' => 'nullable|integer|min:0',
                ],
                [
                    'post_content.required' => 'Content is required.',
                    'media.mimes' => 'Media must be a jpg, jpeg, png, mp4, mov, or avi file.',
                    'media.max' => 'Media must not exceed 20MB.',
                    'post_comment_count.integer' => 'Comment count must be a number.',
                    'post_comment_count.min' => 'Comment count cannot be negative.',
                    'post_like_count.integer' => 'Like count must be a number.',
                    'post_like_count.min' => 'Like count cannot be negative.',
                ]
            );

            //check if there is a media file along the post
            if ($request->hasFile('media')) {
                $file = $request->file('media');

                //determine if the media uploaded is image or video
                $mediaType = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
                $mediaPath = $file->store('uploads/posts', 'public');
            }

            //merging array to pass in other important stuff
            $validatedPostReq = array_merge($validatedPostReq, [
                'user_id' => auth()->user()->id,
                'media_type' => $mediaType,
                'post_media_path' => $mediaPath,
                'post_created_at' => Carbon::now()
            ]);

            $this->postRepository->createPost($validatedPostReq);
            return response()->json(['message' => 'Post created successfully'], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
