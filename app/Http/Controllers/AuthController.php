<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('layout.auth',[
            'title' => 'Login'
        ]);
    }

    public function store_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('error','Please check username and password again!')->withErrors($validator)->withInput();
        }
        $admin = Admin::where('username',$request->username)->first();
        if (!empty($admin)) {
            if (Hash::check($request->password, $admin->password)) {
                Auth::login($admin);
                return redirect()->route('dashboard')->with('success', 'Login success');
            }else {
                return back()->with('error','Login failed, please check username and password again!')->withErrors($validator)->withInput();
            }
        } else {
            return back()->with('error','Login failed, please check username and password again!')->withErrors($validator)->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login')->with("success", "Logout success");
    }
}
