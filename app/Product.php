<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB ;
class Product extends Model
{
    protected $fillable=[
     'user_id','product_name','description','product_code','defult_price','qty','category_id',
     'brand_id','is_active','image','store_id',
    ];
    // public static function image($fileName,$product){
    //     if(request()->hasfile($fileName)){
    //         $file=request()->file($fileName);
    //         $extention= $file->getClientOriginalExtension();
    //         $filename=time().'.'.$extention;
    //         $file->move('image/products/',$filename);
    //         $product->image = $filename; 
    //     }
    // }
    
    public function images(){
        return $this->hasMany(Image::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function colors(){
        return $this->hasMany(Color::class);
    }
    public function sizes(){
        return $this->hasMany(Size::class,);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id');
    }
    public function favourite_to_user(){
        $user=Auth::user();
        return $this->belongsToMany(User::class);
    }
    // public function like(){
    //     // $programs = DB::table('favourites')
    //     // ->selectRaw('favourites.product_id',' count(*) as y')
    //     // ->groupBy('product_id')->get();
    //     // return $programs ;
    //     return $this->favourite()->selectRaw('product_id,count(*) as count')->groupBy('product_id');
    // }
    public function tags(){
        return $this->belongToMany(Tag::class);
    }
    public function deals (){
        return $this->belongsToMany(Deal::class);
    }
}
