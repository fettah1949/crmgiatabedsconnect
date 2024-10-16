<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth ;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        //   dd(Hash::make(123456789));die;
        return view('auth.login');
    }
    public function auth_login(Request $request){

      //  dd($request->all());
       $remember = !empty($request->remember) ? true : false;
    //    'is_admin' => 1,'status' => 0,'is_delete' => 0
    // die($remember);
       if(Auth::attempt(['email' => $request->email , 'password'=> $request->password,],$remember))
       {
        return redirect(('panel/dashbord'));
       }else{
        return redirect()->back()->with('error',"Please entre currect email password");
       }
    }
}