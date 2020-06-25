<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User ;
use App\Store ;
use App\Http\Resources\UserFullResource;

class FollowerController extends Controller
{
    public function followers(Request $request){
        
        $request->validate([
            'store_id'=> 'required'
        ]);

        $data = $request->all();
        $store_id = $request->input('store_id');
        $store = Store::find($store_id);

        return UserFullResource::collection($store->my_followers()->paginate());  
        //$user->favourite_products()->paginate(50);;


    }
    public function edit(Request $request){
        
        $request->validate([
            'store_id'=>'required',
            'user_id'=> 'required'
        ]);

        $data = $request->all();
        $storeID =  $request->input('store_id');
        $store = Store::find($storeID);
        $user = $request->input('user_id');
        $isFollow = $store->my_followers()->where('user_id',$user)->count();
        if($isFollow ==0)
        {
            $store->my_followers()->attach($user);
        }else{
            $store->my_followers()->detach($user);
        }

        return  $store->my_followers()->paginate(8);


    }
}
