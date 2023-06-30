<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersProject;
use Illuminate\Support\Facades\Validator;

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

        $users = UsersProject::where('email', $request->email)
                            -> where('password', $request->password)        
                            -> get();
        
        if(count($users) == 0)
        {
            return view('error');
        }

        return 'Logged in successfully';
    }

    public function showSignUpForm()
    {
        return view('signUp');
    }

    function insertUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'email' =>'required',
                'password' => 'required',
                'password2' => 'required',
                'password2' => 'required|same:password',
        ]);

        
        if ($validator->fails()) {
            return view('error');
        }
        else
        {
            $user = new UsersProject;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->password2 = $request->password2;
            $user->save();
            // $data = $request->only(['email', 'password', 'password2']);
            // UsersProject::create($data);
            return view('success');
        }
              
               
    } 
}