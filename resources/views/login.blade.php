<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='/css/style.css' rel="stylesheet">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
  <body>
    <div class="main">
        <form class="signUp inactive-dx" >
          <h3>Create Your Account</h3>
          <p> enter your information for join</p>
          <input class="w100" type="test" name ="name" placeholder="Insert Full Name" reqired autocomplete='off'/>
          <input class="w100" type="email" placeholder="Insert eMail" autocomplete='off' />
          <input type="password" placeholder="Insert Password" />
          <input type="password" placeholder="Verify Password" />
          <button class="form-btn sx log-in" type="button">Log In</button>
          <button class="form-btn dx" type="button">Sign Up</button>
        </form>

        <form class="signIn active-dx" method="POST">
          @csrf
          <h3>Welcome</br>Back !</h3><br><br>
          <input type="email" name='email' placeholder="Insert eMail" autocomplete='off' reqired /><br><br>
          <input type="password" name='password' placeholder="Insert Password" reqired />
          
          <button class="form-btn sx back" type="button"><a href="/signup"> Sign Up</a>        
            </button>
          <button class="form-btn dx" type="submit">Log In</button>
        </form>
      </div>

      <script>