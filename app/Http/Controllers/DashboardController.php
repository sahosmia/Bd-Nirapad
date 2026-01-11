<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Report;

class DashboardController extends BaseController
{

    public function index()
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
}
