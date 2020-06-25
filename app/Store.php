<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable=[
        'Store_name','description','user_id','address_id','image','cover','shipping_address'
    ];
    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function my_followers(){
        return $this->belongsToMany(User::class);
    }
    
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function storePayments(){
        return $this->hasMany(Payment::class);
    }
    public function deals (){
        return $this->hasMany(Deal::class);
    }
    public function storeOrders(){
        return $this->hasMany(Order::class);
    }
    public function follows(){
        return $this->hasMany(Favourite::class);
    }
    public function shippingAddress(){
        return $this->hasOne(Address::class,'id','shipping_address');
    }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    public function invoices(){
    
        return $this->hasMany(Invoice::class);
    
    }

}
