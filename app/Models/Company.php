<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    public function plan_type_detail(){
        return $this->hasMany(PlanType::class , 'company_id');
    }
}
