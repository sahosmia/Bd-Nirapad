<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\MobileRecharge;
use App\Models\Operator;
use App\Models\Report;
use App\Models\Notification;
use App\Models\PlanType;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;


class MobileRechargeController extends BaseController
{

    public function create()
    {
        $view = 'mobile-recharge';
        $roles = Role::where('id', '!=', 1)->get();
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

    public function store(Request $request)
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

    public function index(Request $request)
    {
        $view = 'mobile-recharge-request';
        $roles = Role::where('id', '!=', 1)->get();
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

    public function update(Request $request, $id)
    {
        $mobilerecharge = MobileRecharge::find($id);
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

                        $reports = Report::where('bank_request_id', $id)->where('form', 3)->first();
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

                    $reports = Report::where('bank_request_id', $id)->where('form', 3)->first();
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
}
