<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class BankRequest extends Model
{
    public function bank_detail(){
        return $this->belongsTo(Bank::class , 'bank_id');
    }

    public function bank_district_detail(){
        return $this->belongsTo(BankDistrict::class , 'bank_district_id');
    }

    public function bank_branch_detail(){
        return $this->belongsTo(BankBranchName::class , 'bank_branch_id');
    }
    
    public function request_detail(){
        return $this->hasOne(Report::class , 'bank_request_id');
    }

    public function user_detail(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
