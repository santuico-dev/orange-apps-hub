<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostInteractionController;
use App\Http\Controllers\UserInteractionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//AUTH
Route::middleware('throttle:api')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/signup', 'signup');
});

Route::middleware(['auth:api', 'throttle:api'])->group(function () {

    //POST
    Route::controller(PostController::class)->group(function () {

        Route::get('/fetchAllPost', 'fetchAllPost');
        Route::get('/fetchPostByPostID/{postID}', 'fetchPostByPostID');
        Route::get('/fetchPostByUserID/{userID}', 'fetchPostByUserID');

        Route::post('/createPost', 'createPost');
    });

    //INTERACTIONS
    Route::controller(PostInteractionController::class)->group(function () {

        Route::get('/fetchPostCommentsByPostID/{postID}', 'fetchPostCommentsByPostID');

        Route::post('/createPostComment', 'createPostComment');
        Route::patch('/likePost/{postID}', 'likePost');
    });

    Route::controller(UserInteractionController::class)->group(function () {

        Route::get('/fetchMyFriendRequests', 'fetchMyFriendRequests');
        Route::get('/fetchMyFriends', 'fetchMyFriends');
        Route::get('/fetchFriendSuggestion', 'fetchFriendSuggestion');
        Route::get('/fetchPendingFriendRequests', 'fetchPendingFriendRequests');
        Route::get('/fetchSentPendingFriendRequests', 'fetchSentPendingFriendRequests');

        Route::get('/findUserByName/{name}', 'fetchUserByName');

        Route::post('/createFriendRequest', 'createFriendRequest');

        Route::post('/acceptFriendRequest', 'acceptFriendRequest');
        Route::post('/rejectFriendRequest', 'rejectFriendRequest');

        Route::delete('/removeFriend/{friendID}', 'removeFriend');
    });
});
