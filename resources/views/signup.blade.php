<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='/css/style.css' rel="stylesheet">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
  </head>
  <body>
    <div class="container">
        <form class="signUp active-dx" action="/signup" method="POST">
          @csrf
          <h3>Create Your Account</h3>
          <p>Just enter your email address</br>
      and your password for join.
          </p>
          <input class="w100" type="email" name ="email" placeholder="Insert eMail" reqired autocomplete='off' value ={{old('email')}}/>
          <input type="password"  name ="password" placeholder="Insert Password" reqired />
          <input type="password"  name ="password2" placeholder="Verify Password" reqired />
          <button class="form-btn sx log-in" type="button"><a href="/login"> Back</a> </button>
          <button class="form-btn dx" type="submit">Submit</button>
        </form>

        <form class="signIn inactive-dx">
          <h3>Welcome</br>Back !</h3>
          <input type="email" placeholder="Insert eMail" autocomplete='off' reqired />
          <input type="password" placeholder="Insert Password" reqired />
          <button class="form-btn sx back" type="button">Back</button>
          <button class="form-btn dx" type="submit">Log In</button>
        </form>
      </div>

      <script>