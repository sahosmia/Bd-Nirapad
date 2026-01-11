<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $view->with('notifications', Notification::where('recievers_user_id', Auth::user()->id)
                ->take(10)
                ->get());
        } else {
            $view->with('notifications', collect());
        }
    }
}
