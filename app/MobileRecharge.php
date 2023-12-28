<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDO;
use App\Models\User;

class MobileRecharge extends Model
{
    public function operator_detail(){
        return $this->belongsTo(Operator::class , 'operator_id');
    }

    public function plan_detail(){
        return $this->belongsTo(PlanType::class , 'plan_id');
    }

    public function user_detail(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
