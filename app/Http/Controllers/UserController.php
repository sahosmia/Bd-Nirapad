<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Level;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends BaseController
{

    public function users(Request $request, $refkey)
    {
        $view = 'users';
        $user = $this->login_check();
        $created_users = User::where("role_id", "!=", 1)->get();
        $allroles = $this->roles();
        $partners = $this->partners();

        // get role for create user
        if (
            $user->role_id == 1 || $user->role_id == 2
        ) {
            $roles = \TCG\Voyager\Models\Role::whereIn('id', [3, 4, 5])->get();
        } else {
            $roles = \TCG\Voyager\Models\Role::where('id', 4)->get();
        }

        // get level for create user
        if ($user->role_id == 4) {
            if ($user->level == 3) {
                $level = Level::whereIn('id', [1, 2])->get();
            } elseif ($user->level == 2) {
                $level = Level::where('id', 1)->get();
            }
        } else {
            $level = $this->levels();
        }


        if (!isset($request->role) && !isset($request->status) && !isset($request->createdby) && !isset($request->range)) {
            if ($user->role_id == 2 || $user->role_id == 1) {
                $alluser = User::orderBy('id', 'DESC')->where("role_id", "!=", 1)->paginate(10);
            } else {
                $alluser = User::orderBy('id', 'DESC')->where('created_by', $user->id)->paginate(10);
            }
        } else {
            $alluser = User::query();




            // Apply role-based filtering based on the user's role
            if ($user->role_id != 1 && $user->role_id != 2) {
                $alluser = $alluser->where('created_by', $user->id)->where("role_id", "!=", 1);
            } else {
                $alluser = $alluser->orderBy('id', 'DESC')->where("role_id", "!=", 1);
            }

            // Check for other filters in the request
            if ($request->has('status')) {
                $alluser->where('status', $request->status);
            }
            if ($request->has('role')) {
                $alluser->where('role_id', $request->role);
            }
            if ($request->has('createdby')) {
                $alluser->where('created_by', $request->createdby);
            }
            if ($request->has('range')) {
                $range = $request->input('range');
                $dates = explode(
                    'to',
                    $range
                );
                $startDate = trim($dates[0]);
                $endDate = isset($dates[1]) ? trim($dates[1]) : null;

                if (!empty($endDate)) {
                    $date = [$startDate, $endDate];
                    $alluser =  $alluser->where(function ($alluser) use ($date) {
                        $alluser->whereBetween('created_at', $date)->orWhereDate('created_at', $date[0])->orWhereDate('created_at', $date[1]);
                    });
                } else {
                    $alluser->whereDate('created_at', $startDate);
                }
            }

            // Order and paginate the results
            $alluser = $alluser->paginate(10);
        }

        return view('users', compact('user', 'alluser', 'roles', 'level', 'partners', 'allroles', "created_users"));
    }

    public function check_username(Request $request)
    {
        if (isset($request->username)) {
            $findusername = User::where('username', $request->username)->count();
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
            $findemail = User::where('email', $request->email)->count();
            if ($findemail > 0) {
                return response()->json([
                    "status" => "warning",
                    "message" => "Email already exists"
                ]);
            } else {
                return response()->json([
                    "status" => "success",
                    "message" => "Email available"
                ]);
            }
        } else if (isset($request->number)) {
            $findcontact = User::where('contact_no', $request->number)->count();
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

    public function user_submit(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact_no = $request->phone;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role;
        $user->created_by = Auth()->user()->id;
        $user->status = 1;
        if ($request->role == 4) {
            $user->level = $request->level;
        }
        $user->save();
        return response()->json([
            "status" => "success",
            "message" => "User registered successfully"
        ]);
    }

    public function reset_pin_submit(Request $request)
    {
        $user = User::find($request->userid);
        if (isset($user->id)) {
            $pinlength = strlen($request->pin);
            if ($pinlength == 4) {
                $user->pin = $request->pin;
                $user->save();
                return response()->json([
                    "status" => "success",
                    "message" => "Pin has been updated"
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Pin length should be 4 characters"
                ]);
            }
        }
    }

    public function reset_password_submit(Request $request)
    {
        $user = User::find($request->userid);
        if (isset($user->id)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                "status" => "success",
                "message" => "Password has been updated"
            ]);
        }
    }

    public function add_partner_submit(Request $request)
    {
        $finduser = User::find($request->userid);
        if (isset($finduser)) {
            $finduser->partner_id = $request->partners;
            $finduser->save();
            return response()->json([
                "status" => "success",
                "message" => "Partner added against " . ucwords($finduser->name)
            ]);
        }
    }

    public function deactive_account($userid)
    {
        $finduser = User::find($userid);
        if (isset($finduser->id)) {
            $finduser->status = 0;
            $finduser->save();
        }
        return response()->json([
            "status" => "success"
        ]);
    }

    public function active_account($userid)
    {
        $finduser = User::find($userid);
        if (isset($finduser->id)) {
            $finduser->status = 1;
            $finduser->save();
        }
        return response()->json([
            "status" => "success"
        ]);
    }
}
