<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MultipleUploadController;


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

//Route::resource('blogs', BlogController::class);
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::put('/blogs/{id}', [BlogController::class, 'update']);
    Route::post('/multi-image-upload', [MultipleUploadController::class, 'store']);
});
