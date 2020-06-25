<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Favourite;
use App\Product;
use App\Http\Resources\ProductResource;
use App\User ;
use DB; 
use Illuminate\Support\Facades\Auth;


class FavouriteController extends Controller
{
    public function favourites(Request $request){
        
        $request->validate([
            'user_id'=> 'required'
        ]);

        $data = $request->all();
        $user_id = $request->input('user_id');
        $user = User::find($user_id);

        return ProductResource::collection($user->favourite_products()->paginate() );  
        $user->favourite_products()->paginate(50);;


    }
    public function edit(Request $request){
        
        $request->validate([
            'product_id'=>'required',
            'user_id'=> 'required'
        ]);

        $data = $request->all();
        $user = User::find($data['user_id']);
        $product_id = $request->input('product_id');
        $isFavourite = $user->favourite_products()->where('product_id',$product_id)->count();
        if($isFavourite ==0)
        {
            $user->favourite_products()->attach($product_id);
        }else{
            $user->favourite_products()->detach($product_id);
        }

        return  $user->favourite_products()->paginate(8);

    }
}
