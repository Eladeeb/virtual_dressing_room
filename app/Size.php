<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable=[
        'product_id','size','price',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function sizes(){
        return $this->hasMany(Size::class,);
    }
}
