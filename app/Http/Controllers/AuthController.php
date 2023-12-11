<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{   
    private $table = "users";
    public function index(){
        if(Auth::user()){
            return redirect(Auth::user()->level);
        }else{
            return view("login");
        }
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            return response()->json(['status'=>'success','messages'=>"login success"], 200);
        }
        return response()->json(['status'=>'error','messages'=> 'The provided credentials do not match our records' ], 400);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login");
    }
}
