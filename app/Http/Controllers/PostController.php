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

            $fetchAllPostRes = $this->postRepository->fetchAllPost();

            return response()->json(['posts' => $fetchAllPostRes], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function fetchPostByPostID($postID)
    {
        try {

            if (!$this->postRepository->fetchPostByPostID($postID)) {
                return response()->json(['message' => 'Post not found'], 404);
            }

            return $this->postRepository->fetchPostByPostID($postID);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function fetchPostByUserID($userID)
    {
        try {

            if (!$this->postRepository->fetchPostByUserID($userID)) {
                return response()->json(['message' => 'User not found'], 404);
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

            $validatedPostReq = $request->validate([
                'post_content' => 'nullable|string',
                'media' => 'nullable|array',
                'media.*' => 'file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
            ]);

            //merging array to pass in other important stuff
            $validatedPostReq = array_merge($validatedPostReq, [
                'user_id' => auth()->user()->id,
                'post_content' => $validatedPostReq['post_content'],
                'post_created_at' => Carbon::now()
            ]);

            $post = $this->postRepository->createPost($validatedPostReq);
            //check if there is a media file along the post
            if ($request->hasFile('media')) {
                //looping the uploaded files
                foreach ($request->file('media') as $file) {
                    $mediaType = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
                    $mediaPath = $file->store('uploads/posts', 'public');

                    $post->media()->create([
                        'media_path' => $mediaPath,
                        'media_type' => $mediaType,
                    ]);
                }
            }
            return response()->json(['message' => 'Post created successfully'], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
