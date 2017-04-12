<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Auth'], function () {
    Route::post('auth/login', 'LoginController@login');
    Route::get('auth/logout', 'LoginController@logout');
});

Route::group(['namespace' => 'User', 'middleware' => 'jwt.auth'], function () {
    Route::post('users', 'UserController@store');
    Route::get('users/current', 'UserController@read');
    Route::patch('users/current', 'UserController@update');
});

Route::group(['namespace' => 'Chat', 'middleware' => 'jwt.auth'], function () {
    Route::post('chats', 'ChatController@store');
    Route::get('chats', 'ChatController@listChats');
    Route::patch('chats/{id}', 'ChatController@update');
    Route::post('chats/{id}/chat_messages', 'ChatMessagesController@store');
    Route::get('chats/{id}/chat_messages', 'ChatMessagesController@listChatMessages');
});