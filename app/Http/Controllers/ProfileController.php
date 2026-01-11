<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use TCG\Voyager\Models\Role;

class ProfileController extends BaseController
{

     public function check_profile_username(Request $request)
    {
        $user = $this->login_check();
        if (isset($request->username)) {
            $findusername = User::where('id', '!=', $user->id)->where('username', $request->username)->count();
            if ($findusername > 0) {
                return response()->json([
                    "status" => "warning",
                    "message" => "Username already exists"
                ]);
            } else {
                return response()->json([
                    "status" => "success",
                    "message" => "Username available"
                ]);
            }
        } else if (isset($request->email)) {
            $findemail = User::where('id', '!=', $user->id)->where('email', $request->email)->count();
            if ($findemail > 0) {
                return response()->json([
                    "status" => "warning",
                    "message" => "Email already exists"
                ]);
            } else {
                return response()->json([
                    "status" => "success",
                    "message" => "Email available",
                ]);
            }
        } else if (isset($request->number)) {
            $findcontact = User::where('id', '!=', $user->id)->where('contact_no', $request->number)->count();
            if ($findcontact > 0) {
                return response()->json([
                    "status" => "warning",
                    "message" => "Contact Number already exists"
                ]);
            } else {
                return response()->json([
                    "status" => "success",
                    "message" => "Contact Number available"
                ]);
            }
        }
    }

    public function show(Request $request)
    {
        $view = 'profile';
        $roles = Role::where('id', '!=', 1)->get();
        $user = $this->login_check();
        return view($view, compact('user', 'roles'));
    }

    public function update(Request $request)
    {
        $user = $this->login_check();
        if (isset($request->name)) {
            $user->name = $request->name;
        }
        if (isset($request->email)) {
            $user->email = $request->email;
        }
        if (
            isset($request->pin) && isset($request->currpin)
        ) {
            if ($user->pin == $request->currpin) {
                $user->pin = $request->pin;
            } else {
                return response()->json([
                    "status" => 'warning',
                    "message" => "Sorry! we couldn't verify your existing pin"
                ]);
            }
        }
        if (isset($request->password) && isset($request->currpassword)) {
            if (Hash::check($request->currpassword, $user->password)) {
                $user->password = bcrypt($request->password);
            } else {
                return response()->json([
                    "status" => 'warning',
                    "message" => "Sorry! The current password is incorrect."
                ]);
            }
        }
        if (isset($request->number)) {
            $user->contact_no = $request->number;
        }

        $user->save();
        return response()->json([
            "status" => "success",
            "message" => "Profile has been updated"
        ]);
    }

    public function change_password()
    {
        $view = 'change-password';
        $user = $this->login_check();
        return view($view, compact('user'));
    }

    public function change_password_submit(Request $request)
    {
        $user = $this->login_check();
        if (isset($request->password) && isset($request->currpassword)) {
            if (Hash::check($request->currpassword, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return response()->json([
                    "status" => "success",
                    "message" => "Password has been updated"
                ]);
            } else {
                return response()->json([
                    "status" => 'warning',
                    "message" => "Sorry! The current password is incorrect."
                ]);
            }
        }
    }

    public function change_pin()
    {
        $view = 'change-pin';
        $user = $this->login_check();
        return view($view, compact('user'));
    }

    public function change_pin_submit(Request $request)
    {
        $user = $this->login_check();
        if (isset($request->pin) && isset($request->currpin)) {
            if ($user->pin == $request->currpin) {
                $user->pin = $request->pin;
                $user->save();
                return response()->json([
                    "status" => "success",
                    "message" => "Pin has been updated"
                ]);
            } else {
                return response()->json([
                    "status" => 'warning',
                    "message" => "Sorry! we couldn't verify your existing pin"
                ]);
            }
        }
    }

    public function create_pin(Request $request)
    {
        $user = $this->login_check();
        $pinlength = strlen($request->pin);
        if ($pinlength == 4) {
            $user->pin = $request->pin;
            $user->save();
            return response()->json([
                "status" => "success",
                "message" => "Pin created successfully"
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Pin length should be 4 characters"
            ]);
        }
    }
}
