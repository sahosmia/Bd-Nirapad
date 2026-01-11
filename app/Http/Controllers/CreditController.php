<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\CreditRequest;
use App\Models\Notification;
use TCG\Voyager\Models\Role;

class CreditController extends BaseController
{

    public function store(Request $request)
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

    public function refund(Request $request)
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

    public function index(Request $request)
    {
        $roles = Role::where('id', '!=', 1)->get();
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
}
