<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Bank;
use App\Models\BankBranchName;
use App\Models\BankDistrict;
use App\Models\BankRequest;
use App\Models\Report;
use App\Models\Notification;
use App\Models\Level;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;

class BankController extends BaseController
{

    public function create()
    {
        $view = 'bank-form';
        $roles = $this->roles();
        $user = $this->login_check();
        $banks = Bank::where('status', 1)->get();
        return view("bank-form", compact('user', 'banks', 'roles'));
    }

    public function getDistricts($id)
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

    public function getBranches($id)
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

    public function store(Request $request)
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
    public function index(Request $request, $refkey)
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

      public function update(Request $request, $id)
    {
        $master_partner = $this->login_check();
        $bankrequest = BankRequest::find($id);
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

                        $reports = Report::where('bank_request_id', $id)->where('form', 1)->first();
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
                        $this->notification(2, $bankrequest->amount, $master_partner->id, $id);
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

                    $reports = Report::where('bank_request_id', $id)->where('form', 1)->first();
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
}
