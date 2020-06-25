<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\ProductResource;
use App\Store ;
class StoreController extends Controller
{
    public function index(){
        return StoreResource::collection(Store::all());

    }
    public function show($id){
      
        return new StoreResource(Store::find($id)->with(['products','follows'])->paginate());
    }
    
    public function products(Request $request){
        $data = $request->all();
        $storeID=$data['store_id'];
        $store=Store::findOrFail($storeID);
        return ProductResource::collection($store->products()->paginate());
    }
    public function store(Request $request)
    {
        $data = $request->all();

        $storeName=$request->input('store_name');
        if(!$this->storeNameExists($storeName)){
            $message= [
                'error' => true,
                'message' => 'لقد تمت اضافه المتجر من قبل'
            ];
            return response($message ,401);
        }
        $store = new Store;
        $store->store_name = $data['store_name'];
        $store->image = $data['image'];
        $store->user_id = $data['user_id'];
        $store->shipping_address = $data['shipping_address'];
        $store->description =$data['description'];
        $store ->cover = $data['cover'];
        $store->save();
        return new StoreResource($store);
    }


    public function search(Request $request){
        $request->validate([
            'store_search'=>'required',
        ]);
        $searchTerm=$request->input('store_search');
        $stores=Store::where(
            'store_name','LIKE','%'.$searchTerm.'%'
        )->get();


        if( count($stores) > 0 ){
          return  StoreResource::collection($stores);
        }

        $message= [
                'error' => true,
                'message' => 'عفوا لا يوجد كاتجوري بهذا الاسم'
            ];
            return response($message ,200);
    }


    public function update(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'store_id'=>'required',
        ]);
            
            $data = $request->all();
            $store=Store::find($data['store_id']);

            if($store->user_id == $data['user_id'])
            {
                if(!empty($data['store_name'])){
                    $store->store_name = $data['store_name'];
                }
                if(!empty($data['description'])){
                    $store->description = $data['description'];
                }
                if(!empty($data['address'])){
                    $store->commune = $data['address'];
                }
                if(!empty($data['image'])){
                    $store->image = $data['image'];
                }
                if(!empty($data['cover'])){
                    $store->cover = $data['cover'];
                }

               
                $store->save();
                return new StoreResource($store);

            }

    }
  

    public function delete(Request $request)
    {
        $request->validate([
            'store_id'=>'required'
        ]);
        $data = $request->all();
        $storeID=$data['store_id'];
        $store=Store::where(['id'=>$storeID])->delete();
        //$category->destroy($categoryID);
        $message= [
            'scucess' => true,
            'message' => 'لقد تم حذف القسم '
        ];
        return response($message ,200);
    }



    private function storeNameExists($category){
        $category=Store::where(
            'store_name','=',$category
        )->first();
        if( !is_null($category) ){
            return false;
        }
        return true ;
    }
}
