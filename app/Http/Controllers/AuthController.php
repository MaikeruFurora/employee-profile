<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth/login');
    }
    
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('web')->attempt($request->except(['_token','_method']))) {
            
            return redirect()->route('admin.index');

        }else{
            return back()->with('msg', 'Login credentials are invalid');
        }
    }

    public function logout() {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('auth.form');
        }
    }
}
