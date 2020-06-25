<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Image;
use App\User;
use App\Size;
use App\Color;
use App\Review ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Cart ;
use App\Http\Resources\CartResource;


class ProductController extends Controller
{
    public function index(){
        return ProductResource::collection(Product::with(['category','brand','favourite_to_user','store','reviews','images'])->orderBy('id','desc')->paginate());

    }

    public function search(Request $request){
        $request->validate([
            'product_search'=>'required',
        ]);
        $searchTerm=$request->input('product_search');
        $products=Product::where(
            'product_name','LIKE','%'.$searchTerm.'%'
        )->get();


        if( count($products) > 0 ){
            
           return  ProductResource::collection($products);
        }

        $message= [
                'error' => true,
                'message' => 'عفوا لا يوجد منتج بهذا الاسم'
            ];
            return response($message ,200);
    }

    public function show($id){
        return new ProductResource(Product::find($id)->with(['category','brand','favourite_to_user','store','reviews','images'])->paginate());
    }

    private function writeProduct(Request $request , Product $product,$update = false){

        $product->product_name=$request->input('product_name');
        $product->user_id=$request->input('user_id');
        $product->product_code=$request->input('product_code');
        $product->brand_id=$request->input('brand_id');
        $product->image=$request->input('image');
        $product->description=$request->input('product_description');
        $product->defult_price=doubleval($request->input('defult_price'));
        $product->category_id = intval($request->input('product_category'));
        $product->store_id = intval($request->input('store_id'));
        $product->discount=doubleval($request->input('product_discount'));
        $product->save();
        if ( $request->hasFile('product_images')){

            $images = $request->file('product_images');
            if(is_array ( $images) ){
                foreach ( $images as $image){
                  
                    $destination = 'images';
                    $iImage = new Image();
                    $filename = $image->getClientOriginalName();
                    $path = 'C:/Users/Eslam Abdo/Desktop/final/New folder (2)/virtual_dressing_room/public/images/'.$filename;
                    $iImage->url = $path;
                    $iImage->product_id = $product->id;
                    $image->move($destination,$filename);
                    $iImage->save();
                }
            }else{
                $destination = 'images';
                $iImage = new Image();
                $filename = $images->getClientOriginalName();
                $path = 'C:/Users/Eslam Abdo/Desktop/final/New folder (2)/virtual_dressing_room/public/images/'.$filename;
                $iImage->url = $path;
                $iImage->product_id = $product->id;
                $images->move($destination,$filename);
                $iImage->save();
            }
        }
        if ( $request->hasFile('image')){

            $images = $request->file('image');
                $destination = 'images';
                $filename = $images->getClientOriginalName();
                $path = 'C:/Users/Eslam Abdo/Desktop/final/New folder (2)/virtual_dressing_room/public/images/'.$filename;
                $product->image = $path;
               // $images->move($destination,$filename);
            }
        
        if ( $request->input('product_sizes')){

            $sizes = $request->input('product_sizes');

            if(is_array($sizes)){
                
                foreach ( $sizes as $size){
                    $nSize = new Size();
                    $nSize->size = $size;
                    $nSize->price = 50.00;
                    $nSize->product_id = $product->id;
                    $nSize->save();
                }
            }else{
                    $nSize = new Size();
                    $nSize->size = $sizes;
                    $nSize->price = 50.00;
                    $nSize->product_id = $product->id;
                    $nSize->save();
                
            }
            
        }
        if ( $request->input('product_colors')){

            $colors = $request->input('product_colors');

            if(is_array($colors)){
                
                foreach ( $colors as $color){
                    $nColor = new Color();
                    $nColor->color = $color;
                    $nColor->product_id = $product->id;
                    $nColor->save();
                }
            }else{
                $nColor = new Color();
                $nColor->color = $colors;
                $nColor->product_id = $product->id;
                $nColor->save();
                
            }
        }
        $product->save();
        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'=>'required',
            'defult_price'=>'required',
            'product_discount'=>'required',
            'product_category'=>'required',
            'store_id'=>'required',
        ]);
        $product = new Product();
       return $this->writeProduct($request,$product);

    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id'=>'required',
            'user_id'=>'required',
        ]);
        $productID = $request->input('product_id');
        $product=Product::find($productID);
        $userID = $request->input('user_id');
        $user=User::find($userID);
        if($product->user_id == $userID)
        {
            return $this->writeProduct($request,$product);

        }else{
            $message= [
                'scucess' => true,
                'message' => 'لا يمكنك التعديل ع هذا المنتج '
            ];
            return response($message ,200);
        }

    }
    public function newProduct($id = null)
    {
        $product = null;
        if (!is_null($id)) {
            $product = Product::with([
                'category'
            ])->find($id);

        }

        $categories = Category::all();

    }
    public function deleteImage(Request $request){
        $imageID=$request->input('image_id');
        Image::destroy($imageID);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'product_id'=>'required'
        ]);
        $data = $request->all();
        $productID=$data['product_id'];
        $product=Product::where(['id'=>$productID])->delete();
        //$category->destroy($categoryID);
        $message= [
            'scucess' => true,
            'message' => 'لقد تم حذف المنتج '
        ];
        return response($message ,200);
    }

    public function addtocart(Request $request){
        $data= $request->all();
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required',
            'product_price' => 'required',
            'user_id'=> 'required',
            'size'=> 'required',
            'color'=> 'required',
            'product_name'=> 'required',
         ]);
         $user = User::find($data['user_id']);
         $total = $data['product_price']*$data['qty'];
         $product = Product::find($data['product_id']);
         $cartCount =  DB::table('cart')->where(['user_id'=>$user->id,'product_id'=>$product->id])->count();
         if($cartCount == 0)
         {
            DB::table('cart')->insert([
                'product_id'=> $product->id ,'qty'=>$data['qty'] ,'price'=>$data['product_price'],
                'user_id'=>$data['user_id'] ,'product_size'=>$data['size'] ,'product_color'=>$data['color'] ,
                'email'=>$user->email,'total'=>$total ,'product_name'=> $product ->product_name,'product_code'=>"m",
                'image'=>$product->image 
            ]);
            $message= [
                'scucess' => true,
                'message' => 'لقد تم اضافه المنتج الي سله الشراء'
            ];
            $cart = DB::table('cart')->where(['user_id'=>$user->id])->get();
            return new CartResource($cart);
            return response($message ,200);
         }else {
             // $cart =  DB::table('cart')->where(['user_id'=>$user->id,'product_id'=>$product->id])
            DB::table('cart')->where(['user_id'=>$user->id,'product_id'=>$product->id])->update([
                'qty'=>$data['qty'] ,
               'product_size'=>$data['size'] ,'product_color'=>$data['color'] ,
                'total'=>$total ,'product_code'=>"m",'image'=>$product->image
            ]);
            $message= [
                'scucess' => true,
                'message' => 'لقد تم تعديل المنتج'
            ];
            $cart = DB::table('cart')->where(['user_id'=>$user->id])->get();
            return new CartResource($cart);
            return response($message ,200);
         }
       

    }
    public function deleteItem(Request $request){
        $data= $request->all();
        $request->validate([
            'product_id' => 'required',
            'user_id'=> 'required',
         ]);
         $user = User::find($data['user_id']);
         $product = Product::find($data['product_id']);
         DB::table('cart')->where(['user_id'=>$user->id,'product_id'=> $product->id])->delete();
         $userCart = DB::table('cart')->where(['user_id'=>$user->id])->get();
         return new CartResource($userCart);
         $message= [
            'scucess' => true,
            'message' => 'لقد تم حذف المنتج من سله الشراء'
        ];

        return response($message ,200);
    }

    public function cart(Request $request){
        $data= $request->all();
        $request->validate([
            'user_id'=> 'required',
         ]);
        $user = User::find($data['user_id']);
        $userCart = DB::table('cart')->where(['user_id'=>$user->id])->get();
        foreach($userCart as $key => $product){
            //dd($product);
            $productDetils = Product::where('id' ,$product -> product_id)->first();
            $userCart[$key]->image = $productDetils->image ;

        }

        return new CartResource($userCart);
    }

    public function destoryCart(Request $request){
        $data= $request->all();
        $request->validate([
            'user_id'=> 'required',
         ]);
         $user = User::find($data['user_id']);
        $userCart = DB::table('cart')->where(['user_id'=>$user->id])->delete();
        $message= [
            'scucess' => true,
            'message' => 'لقد تم تفريغ سله الشراء'
        ];
        return response($message ,200);
    }
    public function addProductReview(Request $request){
        $request->validate([
            'user_id'=> 'required',
            'product_id'=>'required',
            'stars'=>'required',
            'customer'=>'required',
         ]);
         $data = $request->all();
         $review = new Review();
         $review->product_id = $data['product_id'];
         $review ->stars = $data['stars'];
         $review ->user_id = $data['user_id'];
         $review ->customer = $data['customer'];
         $review ->review = 'g';
         $review->save();
         
         return new ProductResource(Product::find( $data['product_id'])->with(['category','brand','favourite_to_user','store','reviews','images'])->paginate());


    }
    
}
