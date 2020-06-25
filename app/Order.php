<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=[
        'user_id','store_id','deliver_id','payment_id','transaction_date','status_id'
    ];

    public function customer(){
        return $this->belongsTo(User::class);
    }
    public function cart (){
        return $this->hasOne(Cart::class);
    }
    public function payment(){
        return $this->hasOne(Payment::class);
    }
    public function shipment(){
        return $this->hasOne(Shipment::class);
    }
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
