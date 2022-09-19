<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    public function index()
    {   
        $title = "Login";
        return view("login", compact("title"));
    }

    public function login(LoginRequest $request)
    {   
        $credential = [
            'nik'      => $request->nik,
            'password' => $request->password
        ];

        $payload["status_code"] = 500;
        $payload["message"]     = "User Tidak Cocok";
        
        if(Auth::attempt($credential)) {
            if(Auth::user()->level != 4) {
                $payload["status_code"] = 200;
                $payload["message"]     = "Login Berhasil";
            }else{
                Auth::guard('web')->logout();
                $payload["status_code"] = 500;
                $payload["message"]     = "User Tidak Cocok";
            }
        }
        return response()->json($payload);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/login');
    }
}
