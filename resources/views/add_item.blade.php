<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='/css/style.css' rel="stylesheet">
    <title>Add Item</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>  
 
    <div class=" container2">
       
        <form class="signIn active-dx form3" action="/add_item" method="POST">
         @csrf
         <p class="user_name">User Name: {{ session('userName') }}</p>
          <h3 class="center"> Add Item Form</h3>         
         
          <table >
            <tr>
              <th>Inventory ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Quantity</th>
             
            </tr>
            <tr>
              <td><input class="input_form" type="Text"  name ="inventory_id" maxlength="5" required /></td>
              <td><input class="input_form" type="Text"  name ="name" required /></td>
              <td><input class="input_form" type="Text"  name ="description"  required /></td>
              <td><input  class="input_form" type="number" name ="quantity" min="0" step="1"  required  /></td>
            </tr>
            <table>
              
          <button class="form-btn dx back" type="submit"> Submit </button>
          <button class="form-btn sx back" ><a href="/inventory_table"> Back to Inventory List</a></button>    
          </form>
          <h4 class="session_msg">{{ session('message2') }}</h4>
                    
        </form>
      </div>

      <script>
  
