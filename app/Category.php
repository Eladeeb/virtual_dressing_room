<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=[
        'category_name' ,'description','is_active' ,'image'
    ];
    public function products(){
        return $this->hasMany(Product::class,'category_id','id');

    }
    // public static function image($fileName,$category){
    //     if(request()->hasfile($fileName)){
    //         $file=request()->file($fileName);
    //         $extention= $file->getClientOriginalExtension();
    //         $filename=time().'.'.$extention;
    //         $file->move('image/categories/',$filename);
    //         $category->image = $filename; 
    //     }
    // }
}
