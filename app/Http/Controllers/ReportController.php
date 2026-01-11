<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Report;
use App\Models\Level;
use App\Models\Form;
use App\Models\Company;
use TCG\Voyager\Models\Role;

class ReportController extends BaseController
{

    public function index(Request $request, $refkey)
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

    public function show($refkey)
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
}
