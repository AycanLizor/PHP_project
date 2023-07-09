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
        
        session(['message' => '']);
        return redirect('inventory_table');
    }
}

//*******************UPDATE ITEM*********/php

public function showUpdateItemForm()
{   
    return view('update_item');
}

public function checkingItem(Request $request){
    
    $items = InventoryProject::get(['inventory_id', 'name', 'description', 'quantity', 'created_at', 'updated_at']);
    $redisKey = 'inventory_id';
    $data = [];
    $inventory_id = $request->item_id;

    foreach($items as $item) {
     Redis::hmset($redisKey.':'.$item->inventory_id,[
        'name'=>$item->name,
        'description'=>$item->description,
        'quantity'=>$item->quantity,
        'created_at'=>$item->created_at,
        'updated_at'=>$item->updated_at,
     ]); 
           
     if (Redis::exists($redisKey . ':' . $inventory_id)) {
        $data = Redis::hgetall($redisKey . ':' . $inventory_id);
        break;
     }
    }
     return view('update_item')->with('data', $data)->with('inventory_id', $inventory_id);
  }

public function edit($inventory_id){
    $item = InventoryProject::find($inventory_id);
    return view('update_item', compact('item','inventory_id'));
}  

public function updateItem(Request $request, $inventory_id)
{
        
    $validator = Validator::make($request->all(), [
        'inventory_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'quantity' => 'required',
    ]);

    if ($validator->fails()) {
        session(['message' => 'Item does not exist or quantity is not valid!']);
        return redirect('update_item');
    }

    $inventory_id = $request->inventory_id;
    $name = $request->name;
    $description = $request->description;
    $quantity = $request->quantity;


    // $inventory_id = isset($request->inventory_id) ? $request->input('inventory_id') : '';
    // $name = isset($request->name) ? $request->input('name') : '';
    // $description = isset($request->description) ? $request->input('description') : '';
    // $quantity = isset($request->quantity) ? $request->input('quantity') : '';

    //$item = InventoryProject::where('inventory_id', $inventory_id)->first();
    $item = InventoryProject::find($inventory_id);

    if ($item) {
        $item->name = $name;
        $item->description = $description;
        $item->quantity = $quantity;
        $item->save();
        session(['message' => 'Item was updated successfully!']);
        return redirect('update_item');
    }
    session(['message' => 'Item does not exist or quantity is not valid!']);
        return redirect('update_item');
 }

//  public function edit($inventory_id)
//  {
//     $item = InventoryProject::find($inventory_id); 
//     return view('update_item', compact('item','inventory_id'));
//  }

//  public function update(Request $request, $inventory_id)
//  {
//                 $this->validate($request, [
//                     'inventory_id'  => 'required',
//                     'name'          => 'required',
//                     'description'   => 'required',
//                     'quantity'      => 'required',
//                 ]);
//  $item = InventoryProject::find($inventory_id);
//         $item->inventory_id = request->get('inventory_id');        
//         $item->name = request->get('name'); 
//         $item->description = request->get('description'); 
//         $item->quantity = request->get('quantity'); 
//         $item->save();

//         return redirect()->route('inventory_table');
//  }
  
}
