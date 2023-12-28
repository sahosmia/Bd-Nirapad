<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDO;
use App\Models\User;

class MobileBankingRequest extends Model
{
    protected $table = 'mobile_banking_request';

    public function service_detail(){
        return $this->belongsTo(Service::class , 'service_id');
    }

    public function user_detail(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
