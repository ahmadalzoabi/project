<?php

use App\Http\Controllers\Controller; // new
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController; // new
use App\Http\Controllers\Api\CategoryController; // new
use App\Http\Controllers\Api\PostController; //new
use App\Http\Controllers\Api\CommentController; // new

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

/** 
 * 
 * USER RELATED
 * 
 */

Route::get('/authors', [UserController::class, 'index']);
Route::get('/authors/{id}', [UserController::class, 'show']);
Route::get('/posts/author/{id}', [UserController::class, 'posts']);
Route::get('/comments/author/{id}', [UserController::class, 'comments']);

Route::post('/register', [UserController::class, 'store']);
Route::post('/token', [UserController::class, 'getToken']);


Route::middleware('auth:api')->group(function(){

    Route::post('/update_user/{id}', [UserController::class, 'update']);
    Route::post('/posts',[PostController::class, 'store']);
    Route::post( '/posts/{id}' , [PostController::class, 'update']);
    Route::delete( '/posts/{id}' , [PostController::class, 'destroy']);

    Route::post( '/comments/posts/{id}' ,[CommentController::class, 'store'] );
    Route::post( '/votes/posts/{id}' ,[PostController::class, 'votes'] );
});

// END USER


/** 
 * 
 * POST RELATED
 * 
 */

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/posts/category/{id}',[CategoryController::class, 'posts']);
Route::get('/posts',[PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/comments/post/{id}', [PostController::class, 'comments']);

 // END POST


/** 
 * 
 * COMMENT RELATED
 * 
 */
Route::get('/comments', [CommentController::class, 'index']);

// END COMMENT







Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); 
});



