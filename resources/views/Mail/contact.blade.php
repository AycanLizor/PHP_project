<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='../css/style.css' rel="stylesheet">
    <title>Error</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>  
    <div class="main">
       
        <form class="signIn active-dx">
           @if(session()->has('username'))
          <h4>Welcome, {{ session('username') }}!</h4><br><br>
      @else
          <h4>Welcome!</h4><br><br>
      @endif
    
                        
          <button class="form-btn dx" type="submit"><a href="http://127.0.0.1:8000"> LogIn your account from here</a> </button>
          
        </form>
      </div>

      <script>