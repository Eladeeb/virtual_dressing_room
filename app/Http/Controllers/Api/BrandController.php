<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        return BrandResource::collection(Brand::all());

    }
    
    public function show($id){
        return new BrandResource(Brand::find($id));
    }

    public function products($id){
        $brand=Brand::findOrFail($id);
        return ProductResource::collection($brand->products()->paginate() );
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name'=>'required',

        ]);
        $brandName=$request->input('brand_name');
        if(!$this->brandNameExists($brandName)){
            $message= [
                'error' => true,
                'message' => 'لقد تمت اضافه الماركة من قبل'
            ];
            return response($message ,401);
        }
        $newBrand = new Brand();
        $newBrand->brand_name =$brandName;
        $newBrand->description = $request->input('description');
        //$newCategory->image('image',$newCategory);
        if ( $request->hasFile('image')){

                $images = $request->file('category_image');
                $destination = 'images';
                $filename = $images->getClientOriginalName();
                $path = 'images/'.$filename;
                $newBrand->image_url = $path;
                $images->move($destination,$filename);
                $newBrand->save();
                return new BrandResource($newBrand);

        }else{
            $newBrand->image = '' ;

        }
        $newBrand->save();
        return new BrandResource($newBrand);
    }
    public function update(Request $request)
    {

        $request->validate([
            'brand_name'=>'required',
            'brand_id'=>'required',
        ]);

        $brandName=$request->input('brand_name');
        $brandID=$request->input('brand_id');
        if(!$this->brandNameExists($brandName)){
            $message= [
                'error' => true,
                'message' => 'لقد تمت اضافه الكاتجوري من قبل'
            ];
            return response($message ,401);
        }


        $brand=Brand::find($brandID);
        $brand->brand_name =$brandName;

        $brand->save();
        return new BrandResource($brand);

    }

    public function delete(Request $request)
    {
        $request->validate([
            'brand_id'=>'required'
        ]);
        $data = $request->all();
        $brandID=$data['category_id'];
        $category=Brand::where(['id'=>$categoryID])->delete();
        $message= [
            'scucess' => true,
            'message' => 'لقد تم حذف القسم '
        ];
        return response($message ,200);
    }



    private function brandNameExists($brand){
        $brand=Brand::where(
            'brand_name','=',$brand
        )->first();
        if( !is_null($brand) ){
            return false;
        }
        return true ;
    }
}
