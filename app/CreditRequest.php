<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class CreditRequest extends Model
{
    public function user_detail(){
        return $this->belongsTo(User::class , 'user_id');
    }
    public function sender_details(){
        return $this->belongsTo(User::class , 'recievers_id');
    }
}
