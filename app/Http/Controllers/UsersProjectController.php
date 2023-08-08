<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\UsersProject;
use App\Models\InventoryProject;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactMail;
use DB;
class UsersProjectController extends Controller
{
    public function showLoginForm()
    { 
        return view('login');

    }

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return view('error');
        }

        $user = UsersProject::where('email', $request->email)
        ->where('password', $request->password)
        ->first();

        if (!$user) {
        return view('error');
        }

     
        session(['user_id' => $user->user_id, 'userName' => $user->name]);
        return redirect('inventory_table');
    }

//********************************************************************** */

    public function showSignUpForm()
    {
        return view('signUp');
    }

    function insertUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name' =>'required',
                'email' =>'required|email|unique:users_project',
                'password' => 'required',
                'password2' => 'required|same:password',
        ]);

        
        if ($validator->fails()) {
            return view('error');
        }
        else
        {
            $user = new UsersProject;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            // $data = $request->only(['email', 'password', 'password2']);
            // UsersProject::create($data);

            Mail::to('aycanlizor@gmail.com')->send(new ContactMail());
            return view('success');
        }
              
               
    } 

    public function setCookie(Request $request){
        $expiration =1; //only 1 minute
        $path="/";
        $secure = false;
        $httpOnly = true;
        
        $cookie = cookie("my-cookie", "my-cookie-value", $expiration, $path,$secure, $httpOnly);
        $view = view("form_insert_data");
        //return response ($view)->withCookie($cookie);
         
        }
    
    public function readCookie(Request $request){
        $cookie = $request->cookie("my-cookie"); //my-cookie is the name of the cookie
        dd($cookie);
      }

      public function deleteCookie()
    {
        $cookie= Cookie::forget('my-cookie');
        //return response( "my-cookie was deleted")->withCookie($cookie);
    }


}