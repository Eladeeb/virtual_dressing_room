<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'order_id','user_id', 'email', 'name',
        'phone','city','village','district',
        'commune','street_name',
        'street_number', 'postcode',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
}
