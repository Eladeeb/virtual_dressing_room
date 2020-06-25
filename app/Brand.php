<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable=[
        'brand_name' ,'description','is_active' ,'image'
    ];
    public function products(){
        return $this->hasMany(Product::class,'brand_id','id');

    }
    public static function image($fileName,$brand){
        if(request()->hasfile($fileName)){
            $file=request()->file($fileName);
            $extention= $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('image/brands/',$filename);
            $brand->image = $filename; 
        }
        
    }
}
