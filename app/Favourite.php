<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable=[
        'user_id','product_id',
    ];
    public function owner(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsToMany(Product::class);
    }
}
