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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Auth::routes();

Route::get('/v1/posts', 'PostController@index');
Route::post('/v1/posts', 'PostController@store');
Route::get('/v1/posts/{postId}', 'PostController@show');
Route::put('/v1/posts/{postId}', 'PostController@update');
Route::put('/v1/posts/{postId}/like', 'PostController@like');
Route::put('/v1/posts/{postId}/comment', 'PostController@comment');
Route::delete('/v1/posts/{postId}', 'PostController@destroy');
Route::prefix('/v1/users')->group(function(){
    Route::get('', 'AuthorController@index');
    Route::get('/{userId}', 'AuthorController@show');

});
