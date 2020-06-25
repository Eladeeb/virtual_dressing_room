<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return CategoryResource::collection(Category::all());

    }
    public function show($id){
        return new CategoryResource(Category::find($id));
    }
    public function products($id){
        $category=Category::findOrFail($id);
        return ProductResource::collection($category->products()->paginate() );
    }
    public function store(Request $request)
    {
        $data = $request->all();

        $categoryName=$request->input('category_name');
        if(!$this->categoryNameExists($categoryName)){
            $message= [
                'error' => true,
                'message' => 'لقد تمت اضافه الكاتجوري من قبل'
            ];
            return response($message ,401);
        }
        $category = new Category;
        $category->name = $data['category_name'];
        $category->url = $data['url'];
        $category->parent_id = $data['parent_id'];
        $category->description =$data['description'];
        $category ->status = $data['status'];
        $category->save();
        return new CategoryResource($category);
    }


    public function search(Request $request){
        $request->validate([
            'category_search'=>'required',
        ]);
        $searchTerm=$request->input('category_search');
        $categories=Category::where(
            'name','LIKE','%'.$searchTerm.'%'
        )->get();


        if( count($categories) > 0 ){
            CategoryResource::collection($categories->paginate());
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
            'category_name'=>'required',
            'category_id'=>'required',
        ]);
        $data = $request->all();

        $categoryName=$data['category_name'];
        $categoryID=$data['category_id'];
        $categoryDescription = $data['description'];
        $categoryUrl = $data['url'];
        $categoryParent = $data['parent_id'];
        if(!$this->categoryNameExists($categoryName)){
            $message= [
                'error' => true,
                'message' => 'لقد تمت اضافه الكاتجوري من قبل'
            ];
            return response($message ,401);
        }


        $category=Category::find($categoryID);
        $category->name =$categoryName;
        $category->url = $categoryUrl;
        $category->description =$categoryDescription ;
        $category->parent_id = $categoryParent;

        $category->save();
        return new CategoryResource($category);

    }
    public function subCategory($id)
    {
        $subCategory = Category::where(['parent_id'=>$id]);
        return CategoryResource::collection($subCategory->paginate());


    }

    public function delete(Request $request)
    {
        $request->validate([
            'category_id'=>'required'
        ]);
        $data = $request->all();
        $categoryID=$data['category_id'];
        $category=Category::where(['id'=>$categoryID])->delete();
        //$category->destroy($categoryID);
        $message= [
            'scucess' => true,
            'message' => 'لقد تم حذف القسم '
        ];
        return response($message ,200);
    }



    private function categoryNameExists($category){
        $category=Category::where(
            'name','=',$category
        )->first();
        if( !is_null($category) ){
            return false;
        }
        return true ;
    }
}
