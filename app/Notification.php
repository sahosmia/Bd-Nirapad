<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Notification extends Model
{
    public function user_detail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
