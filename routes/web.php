<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersProjectController;
use App\Http\Controllers\InventoryProjectController;
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

Route::get('/inventory_table', [InventoryProjectController::class,"showInventoryTable"]);
Route::get('/add_item', [InventoryProjectController::class,"showAddItemForm"]);
Route::post('/add_item', [InventoryProjectController::class,"insertItem"]);

Route::get('/update_item/{inventory_id}', [InventoryProjectController::class,"edit"]);
Route::get('/inventory_table/{inventory_id}', [InventoryProjectController::class,"deleteItem"]);
Route::post('/update_item', [InventoryProjectController::class,"updateItem"]);
//Route::get('/checking_item', [InventoryProjectController::class,"checkingItem"]);