<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends BaseController
{
    public function index()
    {
        return Notification::where('recievers_user_id', auth()->user()->id)
            ->take(10)
            ->get();
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return response()->json(['status' => 'success', 'tr' => 'tr_'. $id]);
    }
}
