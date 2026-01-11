<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Level;
use App\Models\Report;
use App\Models\Notification;
use App\Models\Form;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;

class BaseController extends Controller
{
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
}
