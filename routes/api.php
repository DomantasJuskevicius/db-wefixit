<?php

use App\Models\Post;
use App\Http\Controllers\PostsApiController;
use App\Http\Controllers\CommentsApiController;
use App\Http\Controllers\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api'])->group(function ($router){
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::get('/posts', [PostsApiController::class, 'index']);
Route::get('/posts/{post}', [PostsApiController::class, 'getPost']);
Route::get('/posts/{post}/comments', [PostsApiController::class, 'getPostComments']);
Route::post('/posts', [PostsApiController::class, 'store']);
Route::put('/posts/{post}', [PostsApiController::class, 'update']);
Route::delete('/posts/{post}', [PostsApiController::class, 'destroy']);

Route::get('/comments', [CommentsApiController::class, 'index']);
Route::get('/comments/{comment}', [CommentsApiController::class, 'getComment']);
Route::post('/comments', [CommentsApiController::class, 'store']);
Route::put('/comments/{comment}', [CommentsApiController::class, 'update']);
Route::delete('/comments/{comment}', [CommentsApiController::class, 'destroy']);

Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/categories/{category}', [CategoryApiController::class, 'getCategory']);
Route::get('/categories/{category}/posts', [CategoryApiController::class, 'getCategoryPosts']);
Route::post('/categories', [CategoryApiController::class, 'store']);
Route::put('/categories/{category}', [CategoryApiController::class, 'update']);
Route::delete('/categories/{category}', [CategoryApiController::class, 'destroy']);
