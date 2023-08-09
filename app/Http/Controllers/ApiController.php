<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\UsersProject;
use App\Models\InventoryProject;
use App\Models\TransactionsProject;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{

  public function apiDeleteItem(Request $request)
  {       if (!session()->has('user_id') || !session()->has('userName')) {
         return response()->json(['message' => 'You are not authorized, please signin.'], 401);
    } 


      $inventory_id = $request->inventory_id;
      $item = InventoryProject::find($inventory_id);
  
      if (!$item) {
          return response()->json(['message' => 'Item not found'], 404);
      }
  
      $item->delete();
  
      $transactionsProjectController = new TransactionsProjectController();
      $savingTransaction = $transactionsProjectController->addTransaction($item, "Deleted");
  
      return response()->json(['message' => 'Item deleted successfully'], 200);
  }

//********************************************************************** */

  public function apiUpdateItem(Request $request)
  {     
      $validator = Validator::make($request->all(), [
          'inventory_id' => 'required',
          'name' => 'required',
          'description' => 'required',
          'quantity' => 'required|integer|min:0',
      ]);
  
      if ($validator->fails()) {
          return response()->json(['message' => 'Item update failed', 'errors' => $validator->errors()], 422);
      } else {
          $inventory_id = $request->inventory_id;
          $name = $request->name;
          $description = $request->description;
          $quantity = $request->quantity;
  
          $item = InventoryProject::find($inventory_id);
  
          if (!$item) {
              return response()->json(['message' => 'Item not found'], 404);
          }
  
          $item->name = $name;
          $item->description = $description;
          $item->quantity = $quantity;
          $item->save();
  
          $transactionsProjectController = new TransactionsProjectController();
          $savingTransaction = $transactionsProjectController->addTransaction($item, "Updated");
  
          return response()->json(['message' => 'Item updated successfully'], 200);
      }
  }


//********************************************************************** */

  public function apiShowTransactions()
  {    
        if (!session()->has('user_id') || !session()->has('userName')) {
       return response()->json(['message' => 'You are not authorized, please signin.'], 401);
} 
      try {
          $transactions = TransactionsProject::all();
          return response()->json(['transactions' => $transactions], 200);
      } catch (\Exception $e) {
          // Log the exception for debugging
          Log::error($e->getMessage());
          return response()->json(['message' => 'Internal Server Error'], 500);
      }
  }

//********************************************************************** */

  public function apiInsertItem(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'inventory_id' => 'required',
          'name' => 'required',
          'description' => 'required',
          'quantity' => 'required|integer|min:0'
      ]);
  
      if ($validator->fails()) {
          return response()->json(['message' => 'Invalid input, try again!'], 422);
      } else {
          $item = new InventoryProject;
          $item->inventory_id = $request->inventory_id;
          $item->name = $request->name;
          $item->description = $request->description;
          $item->quantity = $request->quantity;
          $item->save();
  
          $item_transaction = InventoryProject::find($item->inventory_id);
          $transactionsProjectController = new TransactionsProjectController();
          $savingTransaction = $transactionsProjectController->addTransaction($item_transaction, "Created");
  
          return response()->json(['message' => 'Item added successfully'], 201);
      }
  }



  //********************************************************************** */
  public function apiShowInventory()
  {        
    
    $items = InventoryProject::all();
    return response()->json(['items' => $items], 200);
    
  }
//********************************************************************** */   

  public function apiLoginUser(Request $request)
  {
  
      $validator = Validator::make($request->all(), [
          'email' => 'required',
          'password' => 'required',
      ]);
  
      if ($validator->fails()) {
          return response()->json(['message' => 'Invalid login/password'], 401);
      }
  
      $user = UsersProject::where('email', $request->email)
          ->where('password', $request->password)
          ->first();
  
      if (!$user || !$user->name) {
          return response()->json(['message' => 'Invalid login/password'], 401);
      }
  
      session(['user_id' => $user->user_id, 'userName' => $user->name]);
      return response()->json(['message' => 'Login successful'], 200);
  }

//********************************************************************** */

public function apiInsertUser(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users_project,email', 
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    }

    try {
        $user = new UsersProject;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        Mail::to($request->email)->send(new ContactMail());

        return response()->json([
            'message' => 'User registered successfully',
            'notification_email' => 'It was sent to the new user',
        ], 201);
    } catch (\Exception $e) {
        
        Log::error($e);

        return response()->json(['message' => 'An error occurred while registering the user'], 500);
    }
}

public function apiSignOut()
{
    try {
        Session::forget('user_id');
        Session::forget('userName');

        return response()->json(['message' => 'Successfully signed out'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error signing out'], 500);
    }
}

}