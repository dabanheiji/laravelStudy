<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/',function(){
    echo "api";
});

Route::namespace('Blogs')->prefix('blogs')->group( function () {
    Route::prefix('user')->group(function(){
        Route::post('login', 'UserController@login');
    });

    Route::prefix('blog')->group(function (){
        Route::get('getBlogs', 'BlogController@getBlogs');
        Route::post('writeBlogs', 'BlogController@writeBlogs');
        Route::get('getBlogDetail', 'BlogController@getBlogDetail');
    });
});