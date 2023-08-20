<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('auth.login');
    }

    public function actionLogin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/purchase');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid email or password']);
    }

    public function logout(Request $request)
    {
        FacadesSession::flush();
        Auth::logout();
        $request->session()->flush();

        return redirect('/login');
    }

}
