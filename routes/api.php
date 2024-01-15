<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
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

Route::post('login', [UserController::class, 'userLogin'])->name('login');
Route::post('register', [UserController::class, 'userRegister'])->name('register');


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('profile', [UserController::class, 'userDetail'])->name('userDetail');
    Route::post('store-post', [PostController::class, 'store'])->name('post.store');
    Route::get('post/{id}',[PostController::class, 'show'])->name('get.post');
    Route::put('update-post/{id}', [PostController::class, 'update']);
});
