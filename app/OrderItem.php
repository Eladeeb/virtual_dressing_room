<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable=[
        'user_id','store_id','order_id','qty','price','color','size','amount'
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }

}
