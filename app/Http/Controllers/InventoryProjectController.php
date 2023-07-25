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

class InventoryProjectController extends Controller
{
//*******************ADDING ITEMS TO THE INVENTORY TABLE*********/
    
public function showAddItemForm()
{   session(['message2' =>'']);
    return view('add_item');
}


public function showInventoryTable()
{   

    $items = InventoryProject::all();
    return view('inventory_table',['items'=>$items]);
  
}


function insertItem(Request $request)
{
      $validator = Validator::make($request->all(), [
            'inventory_id' =>'required',
            'name' =>'required',
            'description' => 'required',
            'quantity' => 'required',
            
    ]);

    
    if ($validator->fails()) {
        session(['message2' => 'Please try again!']);
       return redirect('inventory_table');
    }
    else
    {
        $item = new InventoryProject;
        $item->inventory_id = $request->inventory_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->quantity = $request->quantity;
        $item->save();
        session(['message2' => $request->inventory_id.' was added']);

        $item_transaction = InventoryProject::find($item->inventory_id);
        $transactionsProjectController = new TransactionsProjectController();
        $savingTransaction = $transactionsProjectController->addTransaction($item_transaction,"Created");
        
        return redirect('inventory_table');
    }
}

//*******************UPDATE ITEM*********/php

public function showUpdateItemForm()
{   session(['message2' =>'']);
    return view('update_item');
}


public function edit($inventory_id){
    $data = InventoryProject::find($inventory_id);
    return view('update_item')->with('data', $data)->with('inventory_id', $inventory_id);
}  

public function updateItem(Request $request)
{   session(['message2' =>'']);
        
    $validator = Validator::make($request->all(), [
        'inventory_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'quantity' => 'required|min:0',
    ]);

    if ($validator->fails()) {
        session(['message2' => 'Item does not exist or quantity is not valid!']);
        return redirect('update_item');
    } 

    $inventory_id = $request->inventory_id;
    $name = $request->name;
    $description = $request->description;
    $quantity = $request->quantity;
    $item = InventoryProject::find($inventory_id);
   

    if ($item) {
        $item->name = $name;
        $item->description = $description;
        $item->quantity = $quantity;
        $item->save();

        $item_transaction = InventoryProject::find($item->inventory_id);
        $transactionsProjectController = new TransactionsProjectController();
        $savingTransaction = $transactionsProjectController->addTransaction($item_transaction,"Updated");

        

        session(['message2' => 'Item was updated successfully!']);
                
    }
           return redirect('update_item/'. $inventory_id);
 }

 public function deleteItem(Request $request)
 {  session(['message2' =>'']);
    
    $inventory_id = $request->inventory_id;
    $name = $request->name;
    $description = $request->description;
    $quantity = $request->quantity;

    $item = InventoryProject::find($inventory_id);
    if ($item) {
        $item->delete();
        session(['message2' => $request->inventory_id.' was deleted successfully!']);

        $transactionsProjectController = new TransactionsProjectController();
        $savingTransaction = $transactionsProjectController->addTransaction($item,"Deleted");
          
        
        return redirect('inventory_table');
    } else {
        session(['message2' => $request->inventory_id.' cannot be deleted successfully!']);
        return redirect('inventory_table');
    }

   
  }
}