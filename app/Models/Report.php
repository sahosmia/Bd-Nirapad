<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Bank;
use App\Models\Service;
use App\Models\Operator;

class Report extends Model
{
    public function user_detail(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function reciever_detail(){
        return $this->belongsTo(User::class , 'recievers_user_id');
    }

    public function form_detail(){
        return $this->belongsTo(Form::class , 'form');
    }
    
    public function bank(){
        return $this->belongsTo(Bank::class , 'bank_id');
    }
    
    public function service(){
        return $this->belongsTo(Service::class , 'service_id');
    }
    
    public function operator(){
        return $this->belongsTo(Operator::class , 'operator_id');
    }

}

