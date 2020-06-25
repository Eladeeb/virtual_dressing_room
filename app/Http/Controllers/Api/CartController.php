<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB ;
use Cart ;

class CartController extends Controller
{
    public  function addCart(Request $request)
    { 
        $request->validate([
        'product_id' => 'required',
        'qty' => 'required',
        'product_price' => 'required',
        'user_id'=> 'required',
     ]);
     $user_id = $request->input('user_id');
     $product_id = $request->input('product_id');
     $user=User::findOrFail($user_id);
     $product = Product::find($product_id) ; 

    }
    public  function  index(){
        $user=Auth::user();
        //Cart::add('293ad', 'Product 1', 1, 9.99, ['size' => 'large'])->associate('App/Product');
        // Cart::add($product->id, $product->product_name, 200, 9.99, ['size' => $product->sizes,'color' => $product->sizes])->associate('App/Product');
        // Cart::add($product->id, $product->product_name, 60, 9.99, ['size' => $product->sizes,'color' => $product->sizes])->associate('App/Product');
        // Cart::add($product->id, $product->product_name, 20, 9.99, ['size' => $product->sizes,'color' => $product->sizes])->associate('App/Product');
        // Cart::add($product->id, $product->product_name, 20, 9.99, ['size' => $product->sizes,'color' => $product->sizes])->associate('App/Product');
        // Cart::store($user->id);
        Cart::restore($user->id);
        //$cart1 = add('293ad', 'Product 1', 1, 9.99, ['product_sizes' => 'size'])->associate('App/Product');
        Cart::store($user->id);
        return new CartResource(Cart::content());
        //  dump(Cart::content());
        // $user=Auth::user();
        // $cart=$user->cart;
        // if(is_null($cart)){
        //     $cart = new Cart();
        //     $cart->cart_items =[];
        //     //$cart->user_id =1;
        //     $cart->user_id =Auth::user()->id ;
        //     $cart->total=0;

        // }
        // $finaCartItems=[];
        // if( $cart->cart_items !=[]){
        //     $cartItems=json_decode($cart->cart_items);
        // foreach ($cartItems as $cartItem){
        //     $product=Product::find(intval($cartItem->product->id));
        //     $finaCartItem=new \stdClass();
        //     $finaCartItem->product=new ProductResource($product);
        //     $finaCartItem->qty=number_format(doubleval($cartItem->qty),2);
        //     array_push($finaCartItems,$finaCartItem);
        // }
        // return [
        //     'cart_items'=>$finaCartItems,
        //     'id'=>$cart->id,
        //     'total'=>$cart->total
        // ];
        // }else{
        //     return [
        //         'cart_items'=>$finaCartItems,
        //         'id'=>$cart->id,
        //         'total'=>$cart->total
        //     ]; 
        // }

        
    }
   
    public function addProductToCart(Request $request){
        $request->validate([
           'product_id' => 'required',
           'qty' => 'required',
           'product_price' => 'required',
           'user_id'=> 'required',
           'size'=> 'required',
           'color'=> 'required',
        ]);
        /**
         *
         */

        //$user=Auth::user();
        $user_id = $request->input('user_id');
        Cart::restore($user_id);
        $product_id = $request->input('product_id');
        $user=User::findOrFail($user_id);
       // $user=User::findOrFail($user->id);
        
        $qty = $request->input('qty');
        $size = $request->input('size');
        $color = $request->input('color');
        $price = $request->input('price');
        $product=Product::findOrFail($product_id);
        /**
         * @var $cart Cart
         */
        Cart::add($product->id, $product->product_name, $qty, $price, ['size' => $size,'color' => $color])->associate('App/Product');
        Cart::store($user_id);
        return new CartResource(Cart::content());

        // $cart = $user->cart;
        // if(is_null($cart)){
        //     $cart = new Cart();
        //     $cart->cart_items =[];
        //     $cart->user_id =1;
        //     // $cart->user_id =Auth::user()->id ;
        //     $cart->total=0;

        // }


        // if($cart->inItems($product->id)){
        //     $cart->editProductInCart($product,$qty,$price);
        // }else{
        //     $cart->addProductToCart($product,$qty,$price);
        // }
        // $cart->save();
        // //$user->cart->id = $cart->id ;
        // $user->save();
        // //return new CartResource($cart) ;
        // return $cart;

    }
    public function deleteCartProduct(Request $request){
        $request->validate([
            'row_id' => 'required',
            'user_id'=> 'required',
        
         ]);
         $user_id = $request->input('user_id');
         Cart::restore($user_id);
         $row = $request->input('row_id');
         Cart::remove($row);
         return new CartResource(Cart::content());

    }
 
}
