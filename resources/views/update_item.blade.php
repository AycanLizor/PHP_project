<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='/css/style.css' rel="stylesheet">
    <title>Update Item</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>

  <body>  
     <div class=" container2">
     
        {{-- <form class="signIn active-dx form3" action="{{action('InventoryProjectController@updateItem',$inventory_id)}}" method="POST">--}}
        <form class="signIn active-dx form3" action="/update_item" method="POST">
         @csrf
         <p class="user_name">User Name: {{ session('userName') }}</p>
          <h3 class="center"> Update Item Form</h3>
          
          {{-- <form method="GET" action='/update_item'>
             @csrf --}}
          <div class="container">
            <input name="item_id" type="text" class="text_input" placeholder="Enter Inventory ID" />
            <button value="Check" class="btn_check" type="submit">Check</button>
          </div> 
        {{-- </from> --}}
         
          <table >
            <tr>
              <th>Inventory ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Quantity</th>
             
            </tr>
            <tr>
              <td><input class="input_form" type="text" name="inventory_id" value="{{ isset($inventory_id) ? $inventory_id : '' }}" /></td>
              <td><input class="input_form" type="Text"  name ="name" value="{{ isset($data['name']) ? $data['name'] : '' }}"  /></td>
              <td><input class="input_form" type="Text"  name ="description" value="{{ isset($data['description']) ? $data['description'] : '' }}" /></td>
              <td><input  class="input_form" type="number" name ="quantity" value="{{ isset($data['quantity']) ? $data['quantity'] : '' }}"  /></td>
            </tr>         
            <table>
              <h4 class="error_msg">{{ session('message') }}</h4>

          <button class="form-btn dx back" type="submit"> Submit </button>
          <button class="form-btn sx back" ><a href="/inventory_table"> Back to Inventory List</a></button>    
        </form>
      </div>

  </body>
  
