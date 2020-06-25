<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable=[
        'amount','user_id','order_id','ref_number','status','store_id',
    ];
    public function customer(){
        return $this->belongsTo(User::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
