<?php

namespace App\Http\Controllers;

use App\Repositories\PostInteractionRepository;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostInteractionController extends Controller
{
    protected $postInteractionRepository;
    protected $postRepository;

    public function __construct(PostInteractionRepository $postInteractionRepository, PostRepository $postRepository)
    {
        $this->postInteractionRepository = $postInteractionRepository;
        $this->postRepository = $postRepository;
    }

    public function createPostComment(Request $request)
    {
        try {
            $validatedPostCommentReq = $request->validate(
                [
                    'comment_content' => 'required|string',
                ],
                [
                    'comment_content.required' => 'Comment content is required.',
                ]
            );

            if (!$request->post_id) {
                return response()->json(['message' => 'Post ID is not found'], 404);
            }

            //merging array so I can include the userID, postID, and comment date
            $validatedPostCommentReq = array_merge($validatedPostCommentReq, [
                'user_id' => auth()->user()->id,
                'post_id' => $request->post_id,
                'comment_created_at' => Carbon::now()
            ]);

            //create comment
            $this->postInteractionRepository->createPostComment($validatedPostCommentReq);

            //update the post comment attributes like the comment count
            $this->postRepository->updatePost($request->post_id, [
                'post_comment_count' => $this->postRepository->fetchPostByPostID($request->post_id)->post_comment_count + 1
            ]);

            return response()->json(['message' => 'Comment created successfully'], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function likePost($postID, $userID)
    {
        try {
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
