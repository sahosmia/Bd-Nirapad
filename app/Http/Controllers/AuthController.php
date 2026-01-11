<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function index()
    {
        if(Auth::check()){
            return redirect('/dashboard/home');
        }
        else{
            return view("login");
        }
    }

    public function login_submit(Request $request)
    {
        if (isset($request->email)) {
            $findemail = User::where('email', $request->email)->first();
            if (isset($findemail->id)) {
                if ($findemail->status == 1) {
                    if (Hash::check($request->password, $findemail->password)) {
                        Auth::loginUsingId($findemail->id);
                        return response()->json([
                            "status" => "success",
                            "message" => "Please wait we are redirecting you",
                            "redirect" => "/dashboard/home"
                        ]);
                    } else {
                        return response()->json([
                            "status" => "danger",
                            "message" => "Incorrect password",
                        ]);
                    }
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Your account is blocked. Please contact support",
                    ]);
                }
            }
            $findusername = User::where('username', $request->email)->first();
            if (isset($findusername->id)) {
                if ($findusername->status == 1) {
                    if (Hash::check($request->password, $findusername->password)) {
                        Auth::loginUsingId($findusername->id);
                        return response()->json([
                            "status" => "success",
                            "message" => "Please wait we are redirecting you",
                            "redirect" => "/dashboard/home"
                        ]);
                    } else {
                        return response()->json([
                            "status" => "danger",
                            "message" => "Incorrect password",
                        ]);
                    }
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Your account is blocked. Please contact support",
                    ]);
                }
            }
            $findcontact = User::where('contact_no', $request->email)->first();
            if (isset($findcontact->id)) {
                if ($findcontact->status == 1) {
                    if (Hash::check($request->password, $findcontact->password)) {
                        Auth::loginUsingId($findcontact->id);
                        return response()->json([
                            "status" => "success",
                            "message" => "Please wait we are redirecting you",
                            "redirect" => "/dashboard/home"
                        ]);
                    } else {
                        return response()->json([
                            "status" => "danger",
                            "message" => "Incorrect password",
                        ]);
                    }
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Your account is blocked. Please contact support",
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "danger",
                    "message" => "Sorry! we cannot find any account with your details",
                ]);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
