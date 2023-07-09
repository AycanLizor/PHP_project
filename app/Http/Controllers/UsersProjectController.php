<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersProject;
use App\Models\InventoryProject;
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
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            // $data = $request->only(['email', 'password', 'password2']);
            // UsersProject::create($data);
            return view('success');
        }
              
               
    } 


}