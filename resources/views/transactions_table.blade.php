<?php use App\Http\Controllers\TransactionsProjectController;?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='/css/style.css' rel="stylesheet">
    <title>Transactions</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>  
 
    <div class=" container2">
       
        <form class="signIn active-dx form2">
          @csrf
         
          <p class="user_name">User Name: {{ session('userName') }}</p>
          <h3 class="center"> LIST OF TRANSACTIONS</h3>
        <table >
            <thead>
              <th>Transaction ID</th>
              <th>Inventory ID</th>
              <th>User ID</th>
              <th>User Name</th>
              <th>Type</th>
              <th>Created at</th>
              <th>Updated at</th>
            
            </thead>
            <tbody>
              @foreach ($transactions as $item)
              <tr>
              <td>{{$item->transaction_id}}</td>
              <td>{{$item->inventory_id}}</td>
              <td>{{$item->user_id}}</td>
              <td>{{$item->user_name}}</td>
              <td>{{$item->type}}</td>
              <td>{{$item->created_at}}</td>
              <td>{{$item->updated_at}}</td>
            </tr>
              @endforeach
            </tbody>
            <table><br><br>
             
              <br><br>
            <button class="form-btn form-btn2 sx back" type="button"><a href="/add_item"> Add New</a> </button>
            <button class="form-btn form-btn2 sx back" type="button"><a href="/inventory_table">Back to Inventory List</a></button> 
            <button class="form-btn form-btn2 dx back" type="button"><a href="/"> SignOut</a></button>  
        </form>

        
      </div>

      <script>


           
             
            
  
