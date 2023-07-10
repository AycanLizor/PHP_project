<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UsersProject;
use App\Models\InventoryProject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InventoryProjectController extends Controller
{
//*******************ADDING ITEMS TO THE INVENTORY TABLE*********/
    
public function showAddItemForm()
{
    return view('add_item');
}


public function showInventoryTable()
{    session(['message' =>'']);

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
        session(['message' => 'Please try again!']);
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
        return redirect('inventory_table');
    }
}

//*******************UPDATE ITEM*********/php

public function showUpdateItemForm()
{   
    return view('update_item');
}

// public function checkingItem(Request $request){
    
//     $items = InventoryProject::get(['inventory_id', 'name', 'description', 'quantity', 'created_at', 'updated_at']);
//     $redisKey = 'inventory_id';
//     $data = [];
//     $inventory_id = $request->item_id;

//     foreach($items as $item) {
//      Redis::hmset($redisKey.':'.$item->inventory_id,[
//         'name'=>$item->name,
//         'description'=>$item->description,
//         'quantity'=>$item->quantity,
//         'created_at'=>$item->created_at,
//         'updated_at'=>$item->updated_at,
//      ]); 
           
//      if (Redis::exists($redisKey . ':' . $inventory_id)) {
//         $data = Redis::hgetall($redisKey . ':' . $inventory_id);
//         break;
//      }
//     }
//      return view('update_item')->with('data', $data)->with('inventory_id', $inventory_id);
//   }

public function edit($inventory_id){
    $data = InventoryProject::find($inventory_id);
    return view('update_item')->with('data', $data)->with('inventory_id', $inventory_id);
}  

public function updateItem(Request $request)
{
        
    $validator = Validator::make($request->all(), [
        'inventory_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'quantity' => 'required|min:0',
    ]);

    if ($validator->fails()) {
        session(['message' => 'Item does not exist or quantity is not valid!']);
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
        session(['message' => 'Item was updated successfully!']);
                
    }
           return redirect('update_item/'. $inventory_id);
 }

 public function deleteItem(Request $request)
 {  $inventory_id = $request->inventory_id;
    $name = $request->name;
    $description = $request->description;
    $quantity = $request->quantity;

    $item = InventoryProject::find($inventory_id);
    if ($item) {
        $item->delete();
        session(['message2' => $request->inventory_id.' was deleted successfully!']);
        return redirect('inventory_table');
    } else {
        session(['message2' => $request->inventory_id.' cannot be deleted successfully!']);
        return redirect('inventory_table');
    }

   
  }
}