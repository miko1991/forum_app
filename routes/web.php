<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
    Route::post('logout', 'UserController@logout');
    Route::get('init', 'UserController@init');
});

Route::prefix('categories')->group(function () {
    Route::get('/', 'CategoryController@getCats');
});

Route::prefix('forum')->group(function () {
    Route::get('/{id}', 'ForumController@getForumById');
});

Route::prefix('post')->group(function () {
    Route::post('create', 'PostController@create');
});

Route::prefix('thread')->group(function () {
    Route::get('search/{searchQuery}', 'ThreadController@search');
    Route::post('create', 'ThreadController@create');
    Route::get('/{id}', 'ThreadController@getThreadById');
});