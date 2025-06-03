<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('/');

// Route::get('/login', function () {
//     return view('auth.login');
// });

Route::get('/signup', function () {
    return view('auth.register');
});

Route::get('/newsfeed', function () {
    return view('user.newsfeed');
});

Route::get('/friends', function () {
    return view('user.friendslist');
});

Route::get('/friend-request', function () {
    return view('user.friendrequest');
});

