<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UsersInteractions ;
class InteractionsController extends Controller
{
    public function addInteractions(Request $request){
        $data= $request->all();
        $request->validate([
            'product_id' => 'required',
            'event_value' => 'required',
            'user_id'=> 'required',
         ]);
         $user = User::find($data['user_id']);
         $product = Product::find($data['product_id']);
         $cartCount =  DB::table('users_interactions')->where(['user_id'=>$user->id,'product_id'=>$product->id])->count();
         $value = UsersInteractions::find($data['product_id']);
         if($cartCount == 0)
         {
            DB::table('users_interactions')->insert([
                'product_id'=> $product->id ,'event_value'=>$data['event_value'] ,
                'user_id'=>$data['user_id'] 
            ]);
            
            $interactions = DB::table('users_interactions')->where(['user_id'=>$user->id])->get();
            return new UsersInteractionsResouece($cart);
         }else {
             // $cart =  DB::table('cart')->where(['user_id'=>$user->id,'product_id'=>$product->id])
            if($data['event_value'] > $value ){
                DB::table('users_interactions')->where(['user_id'=>$user->id,'product_id'=>$product->id])->update([
                    'event_value'=>$data['event_value'] 
                ]);
            }
           
            $message= [
                'scucess' => true,
                'message' => 'لقد تم تعديل المنتج'
            ];
            $cart = DB::table('cart')->where(['user_id'=>$user->id])->get();
            return new CartResource($cart);
            return response($message ,200);
         }
       

    }
}
