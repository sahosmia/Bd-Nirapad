<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function create()
    {
        if(Auth::check()){
            return redirect('/dashboard/home');
        }
        else{
            return view("login");
        }
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $loginField = $credentials['email'];

        $user = User::where('email', $loginField)
            ->orWhere('username', $loginField)
            ->orWhere('contact_no', $loginField)
            ->first();

        if (!$user) {
            return response()->json([
                "status" => "danger",
                "message" => "Sorry! we cannot find any account with your details",
            ]);
        }

        if ($user->status != 1) {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! Your account is blocked. Please contact support",
            ]);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                "status" => "danger",
                "message" => "Incorrect password",
            ]);
        }

        Auth::login($user);

        return response()->json([
            "status" => "success",
            "message" => "Please wait we are redirecting you",
            "redirect" => "/dashboard/home"
        ]);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
