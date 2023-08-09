<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersProjectController;
use App\Http\Controllers\InventoryProjectController;
use App\Http\Controllers\TransactionsProjectController; 
use App\Mail\ContactMail;
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

Route::get('/', [UsersProjectController::class,"showLoginForm"]);
Route::post('/', [UsersProjectController::class,"loginUser"]);
Route::get('/signup', [UsersProjectController::class,"showSignUpForm"]);
Route::post('/signup', [UsersProjectController::class,"insertUser"]);
Route::post('/signOut', [UsersProjectController::class, 'signOut']);

Route::get('/inventory_table', [InventoryProjectController::class,"showInventoryTable"]);
Route::get('/inventory_table_redis', [InventoryProjectController::class,"showInventoryTableRedis"]);
Route::get('/add_item', [InventoryProjectController::class,"showAddItemForm"]);
Route::post('/add_item', [InventoryProjectController::class,"insertItem"]);

Route::get('/update_item/{inventory_id}', [InventoryProjectController::class,"edit"]);
Route::get('/inventory_table/{inventory_id}', [InventoryProjectController::class,"deleteItem"]);
Route::post('/update_item', [InventoryProjectController::class,"updateItem"]);
Route::get('/transactions', [TransactionsProjectController::class,"showTransactions"]);

Route::get('/mail', function(){
  Mail::to('aycanlizor@gmail.com')->queue(new ContactMail());
  return view('success');
});