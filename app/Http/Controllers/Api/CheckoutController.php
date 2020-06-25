<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Stripe;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB ;
use App\ShippingAddress ;
use App\ Order ;
use App\ OrderItem ;
class CheckoutController extends Controller
{
    public function index (){
        $request->validate([
            'user_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'street_name'=>'required',
            'phone'=>'required',
        ]);
        $data = $request->all();
        $user_id = $data['user_id'];
        $userDetails = User::find($user_id);
        $userCart = DB::table('cart')->where(['user_id'=>$user->id])->get();

    }
    public function store(Request $request){
        $request->validate([
            'user_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'street_name'=>'required',
            'phone'=>'required',
        ]);
            $data = $request->all();
            $user_id = $data['user_id'];
            $userDetails = User::find($user_id);
            $userCart = DB::table('cart')->where(['user_id'=> $userDetails->id])->get();
            
            $order = new Order();
            $order->user_id = $user_id ;
            $order->payment_id = '111';
            
            $order->status_id = 1 ;
            $order->save() ;
            if($order->save()){
                $userCart = DB::table('cart')->where(['user_id'=>$userDetails->id])->get();
                foreach($userCart as $key => $product){
                    $item = new OrderItem ;
                    
                    $item->order_id = 1 ;
                    //$productDetils = Product::where('id' ,$product -> product_id)->first();
                    $item->product_id =$product ->product_id ;
                    $item ->price = $product ->price ;
                    $item->qty = $product->qty ;
                    $item->amount = $product->total ;
                    $item->color = $product->product_color ;
                    $item->size = $product->product_size ;
                    $item ->save();
                }
                $request->merge([
                    'order_id'=> $order->id 
                ]);
                $data = $request->all();
                if( $shippingCount = ShippingAddress::create($data)){
                    $userCart = DB::table('cart')->where(['user_id'=>$user_id])->delete();
                }
               

            } 
    }

    public function checkout(Request $request){

        $request->validate([
            'user_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'street_name'=>'required',
            'phone'=>'required',
        ]);
        $data = $request->all();
        $user_id = $data['user_id'];
        $userDetails = User::find($user_id);
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        if($shippingCount > 0){
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
      
        }else{

            $shipping =new DeliveryAddress();
            $shipping->user_id =  $data['user_id'];
            $shipping->name = $data['name'];
            $shipping->street_name =$data['street_name'];
            if(!empty($data['postcode'])){
                $shipping->postcode = $data['postcode'];
            }
            if(!empty($data ['commune'])){
                $shipping->commune = $data ['commune'];
            }
            if(!empty($data['district'])){
                $shipping->district =$data['district'];
            }
            if(!empty( $data['village'])){
                $shipping->village = $data['village'];
            }
            if(!empty($data ['city'])){
                $shipping->city = $data ['city'];
            }
            if(!empty(  $data['phone'])){
                $shipping->phone = $data['phone'];
            }
            $shipping->email = $userDetails->email ;

            $shipping->save();

            

            // DeliveryAddress::where('user_id',$user_id)->create(['name'=>$data['name']
            // ,'street_name'=>$data['street_name'],'postcode'=>$data['postcode'],'commune'=>$data['commune']
            // ,'district'=>$data['district'],'village'=>$data['village'],'city'=>$data['city'],'phone'=>$data['phone']]);
        }


    }

    public function orderReview(){
        $request->validate([
            'user_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'street_name'=>'required',
            'phone'=>'required',
        ]);
        $data = $request->all();
        $user_id = $data['user_id'];
        $userDetails = User::find($user_id);
        $user->email = $userDetails->email ;
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();

    }



}
