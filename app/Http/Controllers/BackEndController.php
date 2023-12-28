<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Level;
use App\PlanType;
use App\Report;
use App\Notification;
use App\Bank;
use App\BankBranchName;
use App\BankDistrict;
use App\BankRequest;
use App\Company;
use App\CreditRequest;
use App\MobileBankingRequest;
use App\MobileRecharge;
use App\Operator;
use App\Service;
use App\Form;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PDO;
use \TCG\Voyager\Models\Role;

class BackEndController extends Controller
{


    /* =======================  Common Method Start  ==========================*/

    public function login_check()
    {
        if (Auth::check()) {
            $user = Auth()->user();
        }
        return $user;
    }

    public function get_master_partner()
    {
        $master_partner = User::where("role_id", 6)->first();
        return $master_partner;
    }

    public function roles()
    {
        return \TCG\Voyager\Models\Role::where('id', '!=', 1)->get();
    }
    public function levels()
    {
        return Level::where('status', 1)->get();
    }

    public function partners()
    {
        return User::where('status', 1)->whereIn('role_id', [5, 6])->get();
    }

    public function make_reports($query, $recievers_user_id, $type, $amount, $proof, $bank_request_id, $form, $updated_credits, $recievers_user_previous_credits, $service_id, $operator_id, $bank_id)
    {
        $reports = new Report();
        $reports->user_id = Auth()->user()->id;
        $reports->recievers_user_id = $recievers_user_id;
        $reports->type = $type;
        $reports->service_id = $service_id;
        $reports->operator_id = $operator_id;
        $reports->bank_id = $bank_id;
        $reports->amount = $amount;
        $reports->updated_credits = $updated_credits;
        $reports->recievers_user_previous_credits = $recievers_user_previous_credits;
        $reports->query = $query;
        $reports->bank_request_id = $bank_request_id;
        $reports->form = $form;
        if ($proof != "") {
            $random = Str::random(50);
            $imagename = $random . '.' . $proof->image->extension();
            $reports->proof = $proof->image->move('transaction/', $imagename);
        }
        $reports->save();
        $form = Form::find($form);
    }
    
    public function notification($type, $amount, $user_id, $recievers_user_id)
    {
        $notification = new Notification();

        if ($type == 1) {
            $notification->title = "You have a new bank request for " . $amount . " credits.";
        } elseif ($type == 2) {
            $notification->title = "Success! Your one bank request has successed for " . $amount . " credits";
        } elseif ($type == 3) {
            $notification->title = "Opps! Your one bank request has refunded for " . $amount . " credits";
        } elseif ($type == 4) {
            $notification->title = "You have a new mobile banking request for " . $amount . " credits";
        } elseif ($type == 5) {
            $notification->title = "Success! Your one mobile banking request has successed for " . $amount . " credits";
        } elseif ($type == 6) {
            $notification->title = "Opps! Your one mobile banking request has refunded for " . $amount . " credits";
        } elseif ($type == 7) {
            $notification->title = "You have a new mobile recharge request for " . $amount . " credits";
        } elseif ($type == 8) {
            $notification->title = "Success! Your one mobile recharge request has successed for " . $amount . " credits";
        } elseif ($type == 9) {
            $notification->title = "Opps! Your one mobile recharge request has refunded for " .  $amount . " credits";
        } elseif ($type == 10) {
            $notification->title = "Wow! New Add credits for " . $amount . " credits";
        } elseif ($type == 11) {
            $notification->title = "Opps! New refund credits for " . $amount . " credits";
        }
        
        $notification->recievers_user_id = $recievers_user_id;
        $notification->user_id = $user_id;

        $notification->save();
    }



    public function notifications()
    {
        return Notification::where('recievers_user_id', auth()->user()->id)
            ->take(10)
            ->get();
    }





    /* =======================  Common Method End   ==========================*/



    /* =======================  Login Method Start  ==========================*/
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
    /* =======================  Login Method End   ==========================*/


    /* =======================  Dashboard and All Reports Method Start  ==========================*/
    public function dashboard()
    {
        $view = 'dashboard';
        $user = $this->login_check();
        

        if ($user->role_id != 1 && $user->role_id != 2) {
            if (
                $user->role_id == 5 || $user->role_id == 6
            ) {
                $allrequests = Report::where('recievers_user_id', $user->id)->where("form", "!=", 0)->count();
                $allrequestssuccess = Report::where('recievers_user_id', $user->id)->where("form", "!=", 0)->where('type', 1)->count();
                $allrequestspending = Report::where('recievers_user_id', $user->id)->where("form", "!=", 0)->where('type', 3)->count();
                $allrequestsrefunded = Report::where('recievers_user_id', $user->id)->where("form", "!=", 0)->where('type', 2)->count();
            } else {
                $allrequests = Report::where('user_id', $user->id)->where("form", "!=", 0)->count();
                $allrequestssuccess = Report::where('user_id', $user->id)->where("form", "!=", 0)->where('type', 1)->count();
                $allrequestsrefunded = Report::where('user_id', $user->id)->where(
                    "form",
                    "!=",
                    0
                )->where('type', 2)->count();
                $allrequestspending = Report::where('user_id', $user->id)->where("form", "!=", 0)->where('type', 3)->count();
            }
            $latestusers = User::where('created_by', $user->id)->take(10)->orderBy('id', 'DESC')->get();
        } else {
            $allrequests = Report::where("form", "!=", 0)->count();
            $allrequestssuccess = Report::where('type', 1)->where("form", "!=", 0)->count();
            $allrequestsrefunded = Report::where('type', 2)->where("form", "!=", 0)->count();
            $allrequestspending = Report::where('type', 3)->where("form", "!=", 0)->count();
            $latestusers = User::where("role_id", "!=", 1)->take(10)->orderBy('id', 'DESC')->get();
        }

        return view($view, compact('user', 'latestusers', 'allrequests', 'allrequestssuccess', 'allrequestspending', 'allrequestsrefunded'));
    }

    public function all_reports(Request $request, $refkey)
    {
        $view = 'all-reports';
        $roles = $this->roles();
        $user = $this->login_check();
        // $allusers = User::all();
        $allusers = User::where("role_id", "!=", 1)->get();
        $level = $this->levels();
        $form = Form::where('status', 1)->get();
        $finduser = User::where('ref_key', $refkey)->first();
        $allreports = Report::query();

        // Apply role-based filtering
        if ($user->role_id != 2 && $user->role_id != 1) {
            if ($user->role_id == 5) {
                $allreports = $allreports->where('recievers_user_id', $user->id)->where("form", 2);
            } elseif ($user->role_id == 6) {
                $allreports = $allreports->where('recievers_user_id', $user->id);
            } else {
                $allreports = $allreports->where('user_id', $user->id);
            }
        } elseif ($user->role_id == 1 || $user->role_id == 2) {
            $allreports = $allreports;
        }

        if (
            !$request->has('status') && !$request->has('type') && !$request->has('userid') && !$request->has('range')
        ) {
            $allreports = $allreports->orderBy('id', 'DESC')->paginate(10);
            // Calculate sums based on filtered data
            $success = $allreports->where('type', 1)->sum('amount');
            $refunded = $allreports->where('type', 2)->sum('amount');
            $pending = $allreports->where('type', 3)->sum('amount');
        } else {
            // Apply additional filters from the request
            if ($request->has('status')) {
                $allreports->where('type', $request->status);
            }
            if ($request->has('type')) {
                $allreports->where('form', $request->type);
            }
            if ($request->has('userid')) {
                $allreports->where('user_id', $request->userid);
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
                    $allreports =  $allreports->where(function ($allreports) use ($date) {
                        $allreports->whereBetween('created_at', $date)->orWhereDate('created_at', $date[0])->orWhereDate('created_at', $date[1]);
                    });
                } else {
                    $allreports->whereDate('created_at', $startDate);
                }
            }
            $allreports = $allreports->orderBy('id', 'DESC')->paginate(10);

            // Calculate sums based on filtered data
            $success = $allreports->where('type', 1)->sum('amount');
            $refunded = $allreports->where('type', 2)->sum('amount');
            $pending = $allreports->where('type', 3)->sum('amount');
        }
        return view("all-reports", compact('user', 'allreports', 'roles', 'level', 'form', 'allusers', 'success', 'refunded', 'pending'));
    }

    /* =======================  Dashboard and All Reports Method End   ==========================*/





    /* =======================  User Method Start  ==========================*/

    public function users(Request $request, $refkey)
    {
        $view = 'users';
        $user = $this->login_check();
        $created_users = User::where("role_id", "!=", 1)->get();
        $allroles = Role::where('id', '!=', 1)->get();
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
    /* =======================  User Method End   ==========================*/







    /* =======================  Credit Method Start  ==========================*/
    public function add_credit(Request $request)
    {
        $user = $this->login_check();
        if ($user->pin == $request->pin) {
            $credit = new CreditRequest();
            $reciver = User::find($request->id);
            $updated_credits = $reciver->credits + $request->amount;
            $checkamount = $user->credits - 500;

            if ($user->role_id != 1 && $user->role_id != 2) {
                if ($checkamount < $request->amount) {
                    return response()->json([
                        "status" => "warning",
                        "message" => "There is not enough credits in your account"
                    ]);
                } else {
                    $user->credits = $user->credits - $request->amount;
                    $user->save();
                }
            }

            if ($user->role_id == 1 || $user->role_id == 2) {
                $credit->user_previous_credits = 0;
            } else {
                $credit->user_previous_credits = $user->credits + $request->amount;
            }

            $credit->user_id = $user->id;
            $credit->recievers_id = $request->id;
            $credit->updated_credits = $reciver->credits + $request->amount;
            $credit->amount = $request->amount;
            $credit->type = 1;
            $credit->comment = $request->comment;
            $credit->save();
            $reciver->credits = $updated_credits;
            $reciver->save();

            $this->notification(10, $request->amount, $user->id, $request->id);
            return response()->json([
                "status" => "success",
                "message" => "The amount is credited in recievers account"
            ]);
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Pin is incorrect"
            ]);
        }
    }

    public function refund_credit(Request $request)
    {
        $user = $this->login_check();
        if ($user->pin == $request->pin) {
            $reciver = User::find($request->id);
            $checkamount = $reciver->credits - 500;
            $credit = new CreditRequest();

            if ($checkamount >= $request->amount) {

                if ($user->role_id == 1 || $user->role_id == 2) {
                    $credit->user_previous_credits = 0;
                } else {
                    $credit->user_previous_credits = $user->credits;
                }

                $credit->user_id = $user->id;
                $credit->recievers_id = $request->id;
                $credit->amount = $request->amount;
                $credit->updated_credits = $reciver->credits - $request->amount;
                $credit->type = 2;  //refund-credits
                $credit->comment = $request->comment;
                $credit->save();

                $reciver->credits = $reciver->credits - $request->amount;
                $reciver->save();

                $this->notification(11, $request->amount, $user->id, $request->id);

                if ($user->role_id != 1 && $user->role_id != 2) {
                    $user->credits = $user->credits + $request->amount;
                    $user->save();
                }

                return response()->json([
                    "status" => "success",
                    "message" => "The amount is debited from recievers account"
                ]);
            } else {
                return response()->json([
                    "status" => "warning",
                    "message" => "There is not enough credits in your account"
                ]);
            }
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Pin is incorrect"
            ]);
        }
    }

    public function credit_request(Request $request)
    {
        $roles = $this->roles();
        $user = $this->login_check();

        if (!isset($request->type) && !isset($request->userid) && !isset($request->range)) {
            if ($user->role_id != 1 && $user->role_id != 2) {
                if ($user->role_id == 4) {
                    $allusers = User::where("role_id", 4)->where("partner_id", $user->id)->get();
                    $allrequest = CreditRequest::where('recievers_id', $user->id)->orWhere('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
                    $success = CreditRequest::where('recievers_id', $user->id)->where('type', 1)->orWhere('user_id', $user->id)->sum('amount');
                    $pending = CreditRequest::where('recievers_id', $user->id)->where('type', 3)->orWhere('user_id', $user->id)->sum('amount');
                    $refunded = CreditRequest::where('recievers_id', $user->id)->where('type', 2)->orWhere('user_id', $user->id)->sum('amount');
                } else if ($user->role_id == 3) {
                    $allusers = User::where("role_id", 4)->get();
                    $allrequest = CreditRequest::where('user_id', $user->id)->orWhere('recievers_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
                    $success = CreditRequest::where('user_id', $user->id)->where('type', 1)->orWhere('recievers_id', $user->id)->sum('amount');
                    $pending = CreditRequest::where('user_id', $user->id)->where('type', 3)->orWhere('recievers_id', $user->id)->sum('amount');
                    $refunded = CreditRequest::where('user_id', $user->id)->where(
                        'type',
                        2
                    )->orWhere('recievers_id', $user->id)->sum('amount');
                } else if ($user->role_id == 5 || $user->role_id == 6) {
                    $allusers = [];
                    $allrequest = CreditRequest::where('recievers_id', $user->id)->orWhere('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
                    $success = CreditRequest::where('recievers_id', $user->id)->where('type', 1)->orWhere('user_id', $user->id)->sum('amount');
                    $pending = CreditRequest::where('recievers_id', $user->id)->where('type', 3)->orWhere('user_id', $user->id)->sum('amount');
                    $refunded = CreditRequest::where('user_id', $user->id)->where(
                        'type',
                        2
                    )->orWhere('user_id', $user->id)->sum('amount');
                }
            } else {
                $allusers = User::where(
                    "role_id",
                    "!=",
                    1
                )->get();
                $allrequest = CreditRequest::orderBy('id', 'DESC')->paginate(10);
                $success = CreditRequest::where('type', 1)->sum('amount');
                $pending = CreditRequest::where('type', 3)->sum('amount');
                $refunded = CreditRequest::where('type', 2)->sum('amount');
            }
        } else {
            $allusers = User::where("role_id", "!=", 1)->get();
            $allrequest = CreditRequest::query();

            if (
                $user->role_id == 1 || $user->role_id == 2
            ) {
                $allrequest =  $allrequest;
            } elseif ($user->role_id == 3 || $user->role_id == 4) {
                $userId = $user->id;
                $allrequest = CreditRequest::where(function ($allrequest) use ($userId) {
                    $allrequest->where('user_id', $userId)
                        ->orWhere('recievers_id', $userId);
                });
            } elseif ($user->role_id == 5 || $user->role_id == 6) {
                $allrequest =  $allrequest->where('recievers_id', $user->id);
            }


            if ($request->has('type')) {
                $allrequest = $allrequest->where('type', $request->type);
            }
            if ($request->has('userid')) {
                $request_userid = $request->userid;
                $allrequest =  $allrequest->where(function ($allrequest) use ($request_userid) {
                    $allrequest->where('user_id', $request_userid)->orWhere('recievers_id', $request_userid);
                });
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
                    $allrequest =  $allrequest->where(function ($allrequest) use ($date) {
                        $allrequest->whereBetween('created_at', $date)->orWhereDate('created_at', $date[0])->orWhereDate('created_at', $date[1]);
                    });
                } else {
                    $allrequest =  $allrequest->whereDate('created_at', $startDate);
                }
            }

            $allrequest = $allrequest->orderBy('id', 'DESC')->paginate(10);
            $success = $allrequest->where('type', 1)->sum('amount');
            $pending = $allrequest->where('type', 3)->sum('amount');
            $refunded = $allrequest->where('type', 2)->sum('amount');
        }
        return view("credit-request", compact('user', 'roles', 'allrequest', 'allusers', 'success', 'pending', 'refunded'));
    }
    /* =======================  Credit Method End   ==========================*/







    /* =======================  Bank Method Start  ==========================*/
    public function bank()
    {
        $view = 'bank-form';
        $roles = $this->roles();
        $user = $this->login_check();
        $banks = Bank::where('status', 1)->get();
        return view("bank-form", compact('user', 'banks', 'roles'));
    }

    public function bank_districts($id)
    {
        $bankdistricts = BankDistrict::where('bank_id', $id)->where('status', 1)->get();
        if ($bankdistricts->count() > 0) {
            return response()->json([
                "status" => "success",
                "bankdistricts" => $bankdistricts
            ]);
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! we are unable to fetch districts for this bank"
            ]);
        }
    }

    public function bank_branches($id)
    {
        $bankbranches = BankBranchName::where('bank_district_id', $id)->where('status', 1)->get();
        if ($bankbranches->count() > 0) {
            return response()->json([
                "status" => "success",
                "bankbranches" => $bankbranches
            ]);
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! we are unable to fetch branches for this bank"
            ]);
        }
    }

    public function bank_request_submit(Request $request)
    {
        $user = $this->login_check();
        $master_partner = $this->get_master_partner();
        $bankrequest = new BankRequest();
        $updated_credits = $user->credits - $request->amount;
        $recivers_previous_credits = $master_partner->credits;
        $recievers_user_id = $master_partner->id;
        if ($user->pin == $request->pin) {
            if (
                $master_partner->credits - 500 >= $request->amount
            ) {
                if ($user->credits - 500 >= $request->amount) {
                    $bankrequest->name = $request->name;
                    $bankrequest->number = $request->number;
                    $bankrequest->bank_id = $request->banks;
                    $bankrequest->bank_district_id = $request->district;
                    $bankrequest->bank_branch_id = $request->branch;
                    $bankrequest->amount = $request->amount;
                    $bankrequest->updated_credits = $updated_credits;
                    $bankrequest->recivers_user_previous_credits = $recivers_previous_credits;
                    $bankrequest->status = 3;
                    $bankrequest->user_id = $user->id;
                    $bankrequest->save();
                    $user->credits = $updated_credits;
                    $user->save();

                    $this->make_reports(3, $master_partner->id, 3, $request->amount, "", $bankrequest->id, 1, $updated_credits, $recivers_previous_credits, null, null, $request->banks);
                       $this->notification(1, $request->amount,  $user->id, $master_partner->id);
                   

                    return response()->json([
                        "status" => "success",
                        "message" => "The Bank Request Recieved"
                    ]);
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Not enough credit in your account"
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "warning",
                    "message" => "Master Partner doesn't have sufficient balance. Please contact Admin"
                ]);
            }
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! Pin is incorrect"
            ]);
        }
    }

    // bank request list page
    public function requests(Request $request, $refkey)
    {
        $roles = $this->roles();
        $user = $this->login_check();
        $level = $this->levels();
        $bank = Bank::where('status', 1)->get();
        $allrequests = BankRequest::query();
        if ($user->role_id == 2 || $user->role_id == 1 || $user->role_id == 6) {
            $allrequests = $allrequests->with('request_detail');
        } else {
            $allrequests = $allrequests->with('request_detail')->where('user_id', $user->id);
        }


        if ($request->has('status')) {
            $allrequests->where('status', $request->status);
        }

        if ($request->has('range')) {
            $range = $request->input('range');
            $dates = explode('to', $range);

            $startDate = trim($dates[0]);
            $endDate = isset($dates[1]) ? trim($dates[1]) : null;

            if (!empty($endDate)) {
                $date = [$startDate, $endDate];
                $allrequests =  $allrequests->where(function ($allrequests) use ($date) {
                    $allrequests->whereBetween('created_at', $date)->orWhereDate('created_at', $date[0])->orWhereDate('created_at', $date[1]);
                });
            } else {
                $allrequests->whereDate('created_at', $startDate);
            }
        }


        $allrequests = $allrequests->orderBy('id', 'DESC')->paginate(10);


        return view("all-requests", compact('user', 'allrequests', 'roles', 'level', 'bank'));
    }

      public function ban_request_update(Request $request)
    {
        $master_partner = $this->login_check();
        $bankrequest = BankRequest::find($request->id);
        $sender = User::findOrFail($bankrequest->user_id);

        if (
            $master_partner->pin == $request->pin
        ) {
            if (
                $request->status == 1
            ) {
                if ($master_partner->credits - 500 >= $bankrequest->amount) {

                    if (isset($bankrequest)) {
                        $bankrequest->status = $request->status;
                        $bankrequest->comment = $request->comment;
                        $bankrequest->updated_credits = $sender->credits;
                        $bankrequest->recivers_user_previous_credits = $master_partner->credits;
                        $bankrequest->save();

                        $reports = Report::where('bank_request_id', $request->id)->where('form', 1)->first();
                        if (isset($reports)) {
                            $reports->type = $request->status;
                            $reports->updated_credits = $sender->credits;
                            $reports->recievers_user_previous_credits = $master_partner->credits;
                            $random = Str::random(50);
                            if (isset($request->image)) {
                                $imagename = $random . '.' . $request->image->extension();
                                $reports->proof = $request->image->move('transaction/', $imagename);
                            }
                            $reports->save();
                        }
                        $master_partner->credits = $master_partner->credits - $bankrequest->amount;
                        $master_partner->save();
                        $this->notification(2, $bankrequest->amount, $master_partner->id, $request->id);
                    }
                    return response()->json([
                        "status" => "success",
                        "message" => "Thank You! Transaction status has been updated"
                    ]);
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Not enough credits in your account"
                    ]);
                }
            } else {
                // refund
                if (isset($bankrequest)) {
                    $bankrequest->updated_credits = $sender->credits + $bankrequest->amount;
                    $bankrequest->recivers_user_previous_credits = $master_partner->credits;
                    $bankrequest->status = $request->status;
                    $bankrequest->comment = $request->comment;
                    $bankrequest->save();

                    $reports = Report::where('bank_request_id', $request->id)->where('form', 1)->first();
                    if (isset($reports)) {
                        $reports->updated_credits =
                            $sender->credits + $reports->amount;
                        $reports->recievers_user_previous_credits = $master_partner->credits;
                        $reports->type = $request->status;
                        $reports->save();
                    }

                    $userid = $bankrequest->user_id;
                    $user = User::find($userid);
                    $user->credits = $user->credits + $bankrequest->amount;
                    $user->save();
                }
            }
            $this->notification(3, $bankrequest->amount, $master_partner->id, $request->id);

            return response()->json([
                "status" => "success",
                "message" => "Thank You! Transaction status has been updated"
            ]);
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! Pin is incorrect"
            ]);
        }
    }
    /* =======================  Bank Method End   ==========================*/








    /* =======================  Mobile Bank Method Start  ==========================*/
    public function mobile_banking()
    {
        $roles = $this->roles();
        $user = $this->login_check();
        $services = Service::where('status', 1)->get();
        return view("mobile-banking", compact('user', 'roles', 'services'));
    }

     public function mobile_banking_submit(Request $request)
    {
        $user = $this->login_check();
        $getpartner = User::find($user->partner_id);
        $number_three_code = substr($request->number, 0, 3);
        if ($number_three_code == "019" || $number_three_code == "014" || $number_three_code == "017" || $number_three_code == "013" || $number_three_code == "016" || $number_three_code == "018" || $number_three_code == "015") {
            $mobilebankingreq = new MobileBankingRequest();
            $updated_credits = $user->credits - $request->amount;
            $recivers_previous_credits = $getpartner->credits;

            if ($user->pin == $request->pin) {
                if ($user->partner_id != "") {
                    if ($getpartner->credits - 500 >= $request->amount) {
                        if ($user->credits - 500 >= $request->amount) {
                            $mobilebankingreq->service_id = $request->service;
                            $mobilebankingreq->number = $request->number;
                            $mobilebankingreq->type = $request->type;
                            $mobilebankingreq->updated_credits = $updated_credits;
                            $mobilebankingreq->recivers_user_previous_credits = $recivers_previous_credits;                            $mobilebankingreq->status = 3; // pandding
                            $mobilebankingreq->partner_id = $user->partner_id;
                            $mobilebankingreq->user_id = $user->id;
                            $mobilebankingreq->amount = $request->amount;

                            $user->credits = $updated_credits;
                            $user->save();

                            $mobilebankingreq->save();

                            $this->make_reports(3, $user->partner_id, 3, $request->amount, "", $mobilebankingreq->id, 2, $updated_credits, $getpartner->credits, $request->service, null, null);
                            $this->notification(4, $request->amount, $user->id, $getpartner->id);

                            return response()->json([
                                "status" => "success",
                                "message" => "The Mobile Banking Request Recieved"
                            ]);
                        } else {
                            return response()->json([
                                "status" => "warning",
                                "message" => "Sorry! Not enough credits in your account"
                            ]);
                        }
                    } else {
                        return response()->json([
                            "status" => "warning",
                            "message" => "Your Partner Doesn't Have Sufficient Balance, Please contact Admin"
                        ]);
                    }
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "No Partner Assigned on your account, Please contact Admin"
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "warning",
                    "message" => "Sorry! Pin is incorrect"
                ]);
            }
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Give me a valid number."
            ]);
        }
    }

    public function mobile_banking_request(Request $request, $refkey)
    {
        $view = 'mobile-banking-requests';
        $roles = $this->roles();
        $user = $this->login_check();
        $service = Service::where('status', 1)->get();

        $allrequest = MobileBankingRequest::query();
        if ($request->has('status')) {
            $allrequest->where('status', $request->status);
        }

        if ($request->has('number')) {
            $allrequest->where('number', $request->number);
        }

        if ($request->has('service')) {
            $allrequest->where('service_id', $request->service);
        }

        if ($request->has('range')) {
            $range = $request->input('range');
            $dates = explode('to', $range);

            $startDate = trim($dates[0]);
            $endDate = isset($dates[1]) ? trim($dates[1]) : null;

            if (!empty($endDate)) {
                $date = [$startDate, $endDate];
                $allrequests =  $allrequest->where(function ($allrequest) use ($date) {
                    $allrequest->whereBetween('created_at', $date)->orWhereDate('created_at', $date[0])->orWhereDate('created_at', $date[1]);
                });
            } else {
                $allrequest->whereDate('created_at', $startDate);
            }
        }
        if ($user->role_id == 3 || $user->role_id == 4) {
            $allrequest->where('user_id', $user->id);
        } elseif (
            $user->role_id == 5 || $user->role_id == 6
        ) {
            $allrequest->where('partner_id', $user->id);
        }

        $allrequest = $allrequest->orderBy('id', 'DESC')->paginate(10);
        return view($view, compact('user', 'roles', 'allrequest', 'service'));
    }


    public function mobile_banking_request_update(Request $request)
    {
        $mobilebankingrequest = MobileBankingRequest::find($request->id);
        $requested_user = User::find($mobilebankingrequest->user_id);
        $partner = User::find($mobilebankingrequest->partner_id);
        if ($partner->pin == $request->pin) {
            if ($request->status == 1) {
                if ($partner->credits - 500 >= $mobilebankingrequest->amount) {
                    if (isset($mobilebankingrequest)) {
                        $mobilebankingrequest->status = $request->status;
                        $mobilebankingrequest->comment = $request->comment;
                        $mobilebankingrequest->trxid = $request->trxid;
                        $mobilebankingrequest->digits = $request->digits;
                        $mobilebankingrequest->updated_credits = $requested_user->credits;
                        $mobilebankingrequest->recivers_user_previous_credits = $partner->credits;
                        $mobilebankingrequest->save();

                        $reports = Report::where('bank_request_id', $request->id)->where('form', 2)->first();
                        if (isset($reports)) {
                            $reports->type = $request->status;
                            $reports->updated_credits = $requested_user->credits;
                            $reports->recievers_user_previous_credits = $partner->credits;
                            $reports->save();
                        }

                        $partner->credits = $partner->credits - $mobilebankingrequest->amount;
                        $partner->save();
                        $this->notification(5, $request->amount, $partner->id, $mobilebankingrequest->user_id);
                    }
                    return response()->json([
                        "status" => "success",
                        "message" => "Thank You! Transaction status has been updated"
                    ]);
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Not enough credits in your account"
                    ]);
                }
            } else {
                if (isset($mobilebankingrequest)) {
                    $mobilebankingrequest->updated_credits = $requested_user->credits + $mobilebankingrequest->amount;
                    $mobilebankingrequest->recivers_user_previous_credits = $partner->credits;
                    $mobilebankingrequest->status = $request->status;
                    $mobilebankingrequest->comment = $request->comment;
                    $mobilebankingrequest->trxid = $request->trxid;
                    $mobilebankingrequest->digits = $request->digits;
                    $mobilebankingrequest->save();

                    $reports = Report::where('bank_request_id', $request->id)->where('form', 2)->first();
                    if (isset($reports)) {
                        $reports->updated_credits = $requested_user->credits + $reports->amount;
                        $reports->recievers_user_previous_credits = $partner->credits;
                        $reports->type = $request->status;
                        $reports->save();
                    }

                    $requested_user->credits = $requested_user->credits + $mobilebankingrequest->amount;
                    $requested_user->save();

                    $this->notification(6, $request->amount, $partner->id, $mobilebankingrequest->user_id);
                }
                return response()->json([
                    "status" => "success",
                    "message" => "Thank You! Transaction status has been updated"
                ]);
            }
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! pin number is incorrect"
            ]);
        }
    }
    /* =======================  Mobile Bank Method End   ==========================*/









    /* =======================  Mobile Recharge Method Start  ==========================*/
    public function mobile_recharge()
    {
        $view = 'mobile-recharge';
        $roles = $this->roles();
        $user = $this->login_check();
        $operators = Operator::where('status', 1)->get();
        return view($view, compact('user', 'roles', 'operators'));
    }

    public function check_operator_number_code_valid($request_operator, $request_number)
    {
        $operator = Operator::find($request_operator);

        if ($request_operator == 3 || $request_operator == 4) {
            $parts = explode('-', $request_number);
            $operatordigitsparts = explode(',', $operator->start_codes);
            if ($parts[0] == $operatordigitsparts[0] || $parts[0] == $operatordigitsparts[1]) {
                return true;
            }
            return false;
        } else {
            $parts = explode('-', $request_number);
            if ($parts[0] == $operator->start_codes) {
                return true;
            }
            return false;
        }
    }

    public function mobile_recharge_submit(Request $request)
    {
        $user = $this->login_check();
        $master_partner = $this->get_master_partner();
        if ($user->pin == $request->pin) {
            $mobilerecharge = new MobileRecharge();
            $check_operator_number_code_valid = $this->check_operator_number_code_valid($request->operator, $request->number);
            $updated_credits = $user->credits - $request->amount;
            $recivers_previous_credits = $master_partner->credits;
            if ($master_partner->credits - 500 >= $request->amount) {
                if ($user->credits - 500 >= $request->amount) {
                    if ($check_operator_number_code_valid) {
                        $mobilerecharge->operator_id = $request->operator;
                        $mobilerecharge->number = $request->number;
                        $mobilerecharge->number_type = $request->numbertype;
                        $mobilerecharge->partner_id = $master_partner->id;
                        $mobilerecharge->status = 3;
                        $mobilerecharge->user_id = $user->id;
                        $mobilerecharge->updated_credits = $updated_credits;
                        $mobilerecharge->recivers_user_previous_credits = $recivers_previous_credits;
                        $mobilerecharge->amount = $request->amount;

                        if (isset($request->planid)) {
                            $mobilerecharge->plan_id = $request->planid;
                        }
                        $mobilerecharge->save();

                        $user->credits = $updated_credits;
                        $user->save();

                        $this->make_reports(3, $master_partner->id, 3, $request->amount, "", $mobilerecharge->id, 3, $updated_credits, $recivers_previous_credits, null, $request->operator, null);
                        $this->notification(7, $request->amount, $user->id, $master_partner->id);
                        return response()->json([
                            "status" => "success",
                            "message" => "The Mobile Recharge Request Recieved"
                        ]);
                    } else {
                        return response()->json([
                            "status" => "warning",
                            "message" => "Sorry! Mobile Number is incorrect"
                        ]);
                    }
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Not enough credits in your account"
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "warning",
                    "message" => "Master Partner doesn't have sufficient balance. Please contact with Master Partner"
                ]);
            }
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! Pin is incorrect"
            ]);
        }
    }

    public function mobile_recharge_request(Request $request)
    {
        $view = 'mobile-recharge-request';
        $roles = $this->roles();
        $user = $this->login_check();
        $operator = Operator::where('status', 1)->get();
        $allrequest = MobileRecharge::query();

        if ($request->has('status')) {
            $allrequest->where('status', $request->status);
        }
        if ($request->has('number')) {
            $allrequest->where(
                'number',
                $request->number
            );
        }
        if ($request->has('operator')) {
            $allrequest->where('operator_id', $request->operator);
        }
        if ($request->has('range')) {
            $range = $request->input('range');
            $dates = explode('to', $range);

            $startDate = trim($dates[0]);
            $endDate = isset($dates[1]) ? trim($dates[1]) : null;

            if (!empty($endDate)) {
                $date = [$startDate, $endDate];
                $allrequest =  $allrequest->where(function ($allrequest) use ($date) {
                    $allrequest->whereBetween('created_at', $date)->orWhereDate('created_at', $date[0])->orWhereDate('created_at', $date[1]);
                });
            } else {
                $allrequest->whereDate('created_at', $startDate);
            }
        }

        if ($user->role_id == 1 || $user->role_id == 2) {
            $allrequest = $allrequest->orderBy('id', 'DESC')->paginate(10);
        } elseif ($user->role_id == 3 || $user->role_id == 4) {
            $allrequest = $allrequest->where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
        } else {
            $allrequest = $allrequest->where('partner_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
        }

        return view($view, compact('user', 'roles', 'allrequest', 'operator'));
    }

    public function mobile_recharge_request_update(Request $request)
    {
        $mobilerecharge = MobileRecharge::find($request->id);
        $user = User::find($mobilerecharge->user_id);
        $master_partner = $this->get_master_partner();
        if ($master_partner->pin == $request->pin) {
            if ($request->status == 1) {
                if ($master_partner->credits - 500 >= $mobilerecharge->amount) {
                    if (isset($mobilerecharge)) {
                        $mobilerecharge->status = $request->status;
                        $mobilerecharge->comment = $request->comment;
                        $mobilerecharge->updated_credits = $user->credits;
                        $mobilerecharge->recivers_user_previous_credits = $master_partner->credits;

                        $mobilerecharge->save();

                        $reports = Report::where('bank_request_id', $request->id)->where('form', 3)->first();
                        if (isset($reports)) {
                            $reports->type = $request->status;
                            $reports->updated_credits = $user->credits;
                            $reports->recievers_user_previous_credits = $master_partner->credits;
                            $reports->save();
                        }

                        $master_partner->credits = $master_partner->credits - $mobilerecharge->amount;
                        $master_partner->save();
                        $this->notification(8, $mobilerecharge->amount, $master_partner->id, $mobilerecharge->user_id);
                    }
                    return response()->json([
                        "status" => "success",
                        "message" => "Thank You! Transaction status has been updated"
                    ]);
                } else {
                    return response()->json([
                        "status" => "warning",
                        "message" => "Sorry! Not enough credits in your account"
                    ]);
                }
            } else {
                if (isset($mobilerecharge)) {
                    $mobilerecharge->updated_credits = $user->credits + $mobilerecharge->amount;
                    $mobilerecharge->recivers_user_previous_credits = $master_partner->credits;                    
                    $mobilerecharge->status = $request->status;
                    $mobilerecharge->comment = $request->comment;
                    $mobilerecharge->save();

                    $reports = Report::where('bank_request_id', $request->id)->where('form', 3)->first();
                    if (isset($reports)) {
                        $reports->updated_credits = $user->credits + $reports->amount;
                        $reports->recievers_user_previous_credits = $master_partner->credits;
                        $reports->type = $request->status;
                        $reports->save();
                    }

                    $user->credits = $user->credits + $mobilerecharge->amount;
                    $user->save();
                    $this->notification(9, $mobilerecharge->amount, $master_partner->id, $mobilerecharge->user_id);
                }
                return response()->json([
                    "status" => "success",
                    "message" => "Thank You! Transaction status has been updated"
                ]);
            }
        } else {
            return response()->json([
                "status" => "warning",
                "message" => "Sorry! Pin is incorrect"
            ]);
        }
    }
    /* =======================  Mobile Recharge Method End   ==========================*/







    /* =======================  Profile Method Start  ==========================*/
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
    
    public function profile(Request $request)
    {
        $view = 'profile';
        $roles = $this->roles();
        $user = $this->login_check();
        return view($view, compact('user', 'roles'));
    }

    public function profile_update_submit(Request $request)
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

    /* =======================  Profile Method End   ==========================*/



    public function reports($refkey)
    {
        $view = 'reports';
        $roles = $this->roles();
        $user = $this->login_check();
        $level = $this->levels();
        $finduser = User::where('ref_key', $refkey)->first();
        if (isset($finduser)) {
            if ($finduser->role_id == 2 || $finduser->role_id == 1 || $finduser->role_id == 5) {
                $allreports = Report::orderBy('id', 'DESC')->where('type', 1)->paginate(10);
            } else {
                $allreports = Report::where('user_id', $finduser->id)->where('type', 1)->orderBy('id', 'DESC')->paginate(10);
            }
        } else {
            return redirect('/dashboard/home');
        }
        return view($view, compact('user', 'allreports', 'roles', 'level'));
    }

    public function plans()
    {
        $view = 'plans';
        $roles = $this->roles();
        $user = $this->login_check();
        $company = Company::where('status', 1)->get();
        return view($view, compact('user', 'company', 'roles'));
    }


    public function find_operator($id)
    {
        if (!isset($id)) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid ID provided"
            ]);
        }
        $planTypes = PlanType::with('plan_details')
            ->where('operator_id', $id)
            ->where('status', 1)
            ->get();
        if ($planTypes->isEmpty()) {
            return response()->json([
                "status" => "warning",
                "message" => "No packages found for this operator",
                "data" => []
            ]);
        }
        $data = [];
        foreach ($planTypes as $planType) {
            $planDetails = $planType->plan_details;
            $data[] = [
                "planType" => $planType->toArray(),
                "plans" => $planDetails->toArray()
            ];
        }
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
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
    
    public function delete_notification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return response()->json(['status' => 'success', 'tr' => 'tr_'. $id]);
    }
}
