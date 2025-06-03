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
                    'post_id' => 'required|integer',
                    'comment_content' => 'required|string',
                ],
                [
                    'post_id.required' => 'Post ID is required.',
                    'post_id.integer' => 'Post ID must be an integer.',
                    'comment_content.required' => 'Comment content is required.',
                ]
            );

            $isPostExisting = $this->postRepository->fetchPostByPostID($validatedPostCommentReq['post_id']);
            if (!$isPostExisting) {
                return response()->json(['message' => 'Post not found'], 404);
            }

            //merging array so I can include the userID, postID, and comment date
            $validatedPostCommentReq = array_merge($validatedPostCommentReq, [
                'user_id' => auth()->user()->id,
                'comment_created_at' => Carbon::now()
            ]);

            //create comment
            $this->postInteractionRepository->createPostComment($validatedPostCommentReq);

            //update the post attributes like the comment count
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

    public function fetchPostCommentsByPostID($postID)
    {
        try {
            return $this->postInteractionRepository->fetchPostCommentsByPostID($postID);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function likePost($postID)
    {
        try {

            //guards
            $post = $this->postRepository->fetchPostByPostID($postID);

            if (!$post) {
                return response()->json(['message' => 'Post not found'], 404);
            }

            $isUserLikedPost = $this->postInteractionRepository->togglePostLike($postID, auth()->user()->id);

            //update post attirbutes for likes
            if ($isUserLikedPost) {
                //increment the like count if the user liked the post
                $this->postRepository->updatePost($postID, [
                    'post_like_count' => $post->post_like_count + 1
                ]);
            } else {
                //decrement the like count if the user unliked the post
                $this->postRepository->updatePost($postID, [
                    'post_like_count' => $post->post_like_count - 1
                ]);
            }

            return response()->json(['liked' => $isUserLikedPost], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
