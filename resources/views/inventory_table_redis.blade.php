<?php use App\Http\Controllers\InventoryProjectController;?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='/css/style.css' rel="stylesheet">
    <title>Inventories</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body class="bodyRedis">  
 
    <div class=" container2">
       
        <form class="signIn active-dx form2">
          @csrf
         
          <p class="user_name">User Name: {{ session('userName') }}</p>
          <h3 class="center"> LIST OF INVENTORIES FROM REDIS</h3>
        <table >
            <thead>
              <th>Inventory ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Edit</th>
              <th>Remove</th>
            </thead>
            <tbody>
              @foreach ($items as $item)
              <tr>
              <td>{{ $item['inventory_id'] }}</td>
              <td>{{ $item['name'] }}</td>
              <td>{{ $item['description'] }}</td>
              <td>{{ $item['quantity'] }}</td>
              <td><a class="edit" href="/inventory_table" > Edit</a></td>
              <td><a class="remove" href="/inventory_table">Remove</a></td>  
              </tr>
              @endforeach
            </tbody>
            <table><br><br>
              <h4 class="session_msg">{{ session('message2') }}</h4>
              <br><br>
                    
             
            <button class="form-btn form-btn2 sx back" type="button"><a href="/inventory_table"> Add New</a> </button>
            <button class="form-btn form-btn2 sx back" type="button"><a href="/transactions">Transactions</a></button> 
                        
        </form>
        <form method="POST" action="/signOut">
          @csrf <!-- Add Laravel CSRF token -->
          <button class="form-btn form-btn2 dx back" type="submit">Sign Out</button>
      </form>

        
      </div>

      <script>


           
             
            
  
