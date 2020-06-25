<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable=[
        'end_at','qty','discount',
    ];
    public function products (){
        return $this->belongsToMany(Product::class);
    }
    public function stores (){
        return $this->belongsTo(Store::class);
    }
}
