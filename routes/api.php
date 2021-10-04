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

Route::get('/posts', [PostsApiController::class, 'index']);
Route::post('/posts', [PostsApiController::class, 'store']);
Route::put('/posts/{post}', [PostsApiController::class, 'update']);
Route::delete('/posts/{post}', [PostsApiController::class, 'destroy']);

Route::get('/comments/{postid}', [CommentsApiController::class, 'index']);
Route::post('/comments/{postid}', [CommentsApiController::class, 'store']);
Route::put('/comments/{postid}/{comment}', [CommentsApiController::class, 'update']);
Route::delete('/comments/{postid}/{comment}', [CommentsApiController::class, 'destroy']);

Route::get('/categories', [CategoryApiController::class, 'index']);
Route::post('/categories', [CategoryApiController::class, 'store']);
Route::put('/categories/{category}', [CategoryApiController::class, 'update']);
Route::delete('/categories/{category}', [CategoryApiController::class, 'destroy']);
