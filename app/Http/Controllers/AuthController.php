<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use App\Models\Group;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);


        $admin = Admin::whereUsernameAndPassword($request->username,$request->password)->first();


        if($admin){
            session()->put('admin',$admin);
            return to_route('home');
        }


        return back()->with('error', 'Incorrect Credentials');




    }

}
