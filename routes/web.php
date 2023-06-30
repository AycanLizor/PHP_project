<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [UsersProjectController::class,"showLoginForm"]);
Route::post('/login', [UsersProjectController::class,"loginUser"]);
Route::get('/signup', [UsersProjectController::class,"showSignUpForm"]);
Route::post('/signup', [UsersProjectController::class,"insertUser"]);