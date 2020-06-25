<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password',
        'phone','email_verified','mobile_verified','image','cover','ThreeD_model',
        'city', 'shipping_address','village','commune'
        ,'lan','lat','district',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    
    // public function storeOrders(){

    // }
 

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function store(){
        return $this->hasOne(Store::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function customerPayments(){
        return $this->hasMany(Payment::class);
    }
    
    public function billingAddress(){
        return $this->hasOne(ShippingAddress::class,'id','shipping_address');
    }
    public function favourite_products(){
        return $this->belongsToMany(Product::class);
    }

    public function store_followers(){
        return $this->belongsToMany(Store::class);
    }

    
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    public function invoices(){
    
        return $this->hasMany(Invoice::class);
    
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function formattedName(){
        return $this->first_name." ".$this->last_name ;
    }
}
