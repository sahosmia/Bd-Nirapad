<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PlanType extends Model
{
    public function plan_details(){
        return $this->hasMany(Plan::class , 'plan_type_id');
    }
}
