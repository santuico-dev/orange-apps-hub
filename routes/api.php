<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostInteractionController;
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

//POST
Route::middleware(['auth:api', 'throttle:api'])->group(function () {

    Route::controller(PostController::class)->group(function () {
        Route::post('/createPost', 'createPost');
    });

    Route::controller(PostInteractionController::class)->group(function () {
        Route::post('/createPostComment', 'createPostComment');
        Route::patch('/likePost/{postID}', 'likePost');
    });
});
