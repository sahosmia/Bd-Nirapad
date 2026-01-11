<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\MobileBankingRequest;
use App\Models\Service;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;

class MobileBankingController extends BaseController
{

    public function mobile_banking()
    {
        $roles = Role::where('id', '!=', 1)->get();
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
        $roles = Role::where('id', '!=', 1)->get();
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
}
