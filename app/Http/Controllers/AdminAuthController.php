<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminAuthController extends Controller
{
    public function login()
    {
        $email    = Request::input('email')['value'];
        $password = Request::input('password')['value'];

        if(!User::where('email', $email)->exists())
        {
            return [
                'status' => 404,
                'statusText' => 'email not found',
                'emailError' => true
            ];
        }

        if(!Auth::attempt(['email' => $email,'password' => $password])){
            return [
                'status' => 404,
                'statusText' => 'password error',
                'passwordError' => true
            ];
        }

        return [
            'status' => 200,
            'statusText' => 'user logged in',
        ];
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}