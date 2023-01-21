<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Api\UserController;

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

Route::post('register', [UserController::class, 'register']);
Route::get('login', [UserController::class, 'loginGet'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('book', BookController::class);
    Route::post('logout', [UserController::class, 'logout']);
});
