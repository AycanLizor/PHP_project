<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UsersProject;
use App\Models\InventoryProject;
use App\Models\TransactionsProject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InventoryProjectController;

class TransactionsProjectController extends Controller
{

    

public function showTransactions()
{    session(['message2' =>'']);

    $transactions = TransactionsProject::all(); // Fetch transactions from the database
    return view('transactions_table', ['transactions' => $transactions]);
  
}

public function addTransaction(InventoryProject $inventory, $type){

    $transaction = new TransactionsProject;
    $transaction->inventory_id = $inventory->inventory_id;
    $transaction->user_id = session('user_id');
    $transaction->user_name = session('userName');
    $transaction->type = $type;
    $transaction->quantity = $inventory->quantity;
    $transaction->created_at = $inventory->created_at;
    $transaction->save();
  
}

}