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
use App\Http\Controllers\TransactionsProjectController;
use Carbon\Carbon;

class InventoryProjectController extends Controller
{
//*******************ADDING ITEMS TO THE INVENTORY TABLE*********/
    
public function showAddItemForm()
{   
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/'); // Redirect to the login page or another appropriate action
    }    
    session(['message2' => '']);
    return view('add_item');
}


public function showInventoryTableRedis()
{    
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/'); // Redirect to the login page or another appropriate action
    }
       
    session(['message_error' => '']);

    $keys = Redis::keys('Inventory:*');
    $items = [];
   
    foreach ($keys as $key) {
        $newKey = ltrim($key, 'laravel_database_');
        $item = Redis::hgetall($newKey);
        $item['inventory_id']=$newKey;
        $items[]=$item;
    }

    return view('inventory_table_redis', ['items' => $items]);
}
//*************************************************************/

public function showInventoryTable()
{    
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/'); // Redirect to the login page or another appropriate action
    }
       
    session(['message_error' => '']);

    $items = InventoryProject::all(); // Retrieve data from MySQL database
    return view('inventory_table', ['items' => $items]);
}

//************************************************************ */
public function insertItem(Request $request)
{    
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/');
    }

    session(['message2' => '']);
    
    $validator = Validator::make($request->all(), [
        'inventory_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'quantity' => 'required|integer|min:0'
    ]);

    if ($validator->fails()) {
        session(['message_error' => 'Invalid input, try again!']);
        return redirect()->back()->withErrors($validator)->withInput();
    } else {
        $item = new InventoryProject;
        $item->inventory_id = $request->inventory_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->quantity = $request->quantity;
        $item->save(); // Save data to MySql.

       
        $id = 'Inventory:'.$item->inventory_id; // Create id for Redis.
        $itemRedis = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
        ];
         
        Redis::hmset($id, $itemRedis); // Save data to Redis.

        session(['message2' => $request->inventory_id . ' was added']);

        $item_transaction = InventoryProject::find($item->inventory_id);
        $transactionsProjectController = new TransactionsProjectController();
        $savingTransaction = $transactionsProjectController->addTransaction($item_transaction, "Created");
        
        return redirect('inventory_table');
    }
}

//*******************UPDATE ITEM*********/php

public function showUpdateItemForm()
{  
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/'); // Redirect to the login page or another appropriate action
    }
    
    return view('update_item');
}


public function edit($inventory_id){
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/'); // Redirect to the login page or another appropriate action
    }
     
    $data = InventoryProject::find($inventory_id);
    return view('update_item')->with('data', $data)->with('inventory_id', $inventory_id);
} 

//*************************************************** */

public function updateItem(Request $request)
{   
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/'); // Redirect to the login page or another appropriate action
    }

    $validator = Validator::make($request->all(), [
        'inventory_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'quantity' => 'required|integer|min:0', // Add the 'integer' rule and set 'min:0' to disallow negative values.
    ]);

    if ($validator->fails()) {
        session(['message_error' => 'Item does not exist or quantity is not valid!']);
        return redirect()->back()->withErrors($validator)->withInput();
    } else {
        $inventory_id = $request->inventory_id;
        $name = $request->name;
        $description = $request->description;
        $quantity = $request->quantity;
        $item = InventoryProject::find($inventory_id);
        session(['message2' => '']); 
                  
        if ($item) {
            $item->name = $name;
            $item->description = $description;
            $item->quantity = $quantity;
            $item->save();


            $itemKey = 'Inventory:' . $inventory_id;
            $itemRedis = Redis::hgetall($itemKey);
            $itemRedis['name'] = $name;
            $itemRedis['description'] = $description;
            $itemRedis['quantity'] = $quantity;
            Redis::hmset($itemKey, $itemRedis);
            

            $item_transaction = InventoryProject::find($item->inventory_id);
            $transactionsProjectController = new TransactionsProjectController();
            $savingTransaction = $transactionsProjectController->addTransaction($item_transaction, "Updated");

            session(['message2' => $request->inventory_id.' was updated successfully!']);
        }

        return redirect('inventory_table');
    }
}


//******************************************************* */


 public function deleteItem(Request $request)
 {  
    if (!session()->has('user_id') || !session()->has('userName')) {
        return redirect('/'); // Redirect to the login page or another appropriate action
    }
    
    
    session(['message2' =>'']);
    
    $inventory_id = $request->inventory_id;
    $name = $request->name;
    $description = $request->description;
    $quantity = $request->quantity;

    $item = InventoryProject::find($inventory_id);
    if ($item) {
        $item->delete();
        session(['message2' => $request->inventory_id.' was deleted successfully!']);

       
        $itemKey = 'Inventory:' . $inventory_id;
        $itemRedis = Redis::hgetall($itemKey);
        Redis::del($itemKey);


        $transactionsProjectController = new TransactionsProjectController();
        $savingTransaction = $transactionsProjectController->addTransaction($item,"Deleted");
          
        
        return redirect('inventory_table');
    } else {
        session(['message2' => $request->inventory_id.' cannot be deleted!']);
        return redirect('inventory_table');
    }
  
  }
}