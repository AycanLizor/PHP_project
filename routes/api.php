<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController; 
use Illuminate\Support\Facades\Log;

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
Route::post('/apiLogin', [ApiController::class,"apiLoginUser"]);
Route::post('/apiInsertUser', [ApiController::class,"apiInsertUser"]);
Route::get('/apiInventory', [ApiController::class,"apiShowInventory"]);
Route::post('/apiInsertItem', [ApiController::class,"apiInsertItem"]);
Route::get('/apiTransactions', [ApiController::class,"apiShowTransactions"]);

Route::post('/apiUpdateItem', [ApiController::class,"apiUpdateItem"]);
Route::get('/apiDeleteItem', [ApiController::class,"apiDeleteItem"]);

// Route::get('/test-database', function () {
//     $user = \App\Models\UsersProject::find(1); // Replace with an existing user ID
//     return response()->json($user);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});