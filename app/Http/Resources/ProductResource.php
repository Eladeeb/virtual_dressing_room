<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        return [
            
            'product_id' =>$this->id,
            'product_name' => $this->product_name ,
            'product_description' =>$this->description,
            'defult_price' =>  number_format($this->defult_price,2),
            'product_discount' =>number_format($this->discount,2),
            'product_fav' => new BrandResource($this->favourite_to_user),
            'store' => new StoreResource($this->store),
            'product_category' => new CategoryResource($this->category),
            'product_images'=>ImageResource::collection($this->images),
            'product_colors'=>ColorResource::collection($this->colors),
            'product_sizes'=>SizeResource::collection($this->sizes),
            'product_brand' => new BrandResource($this->brand),
            //'image' => $this->image ,
            'user_id'=>$this->user_id,
            'product_code'=>$this->product_code,
        ];
    }
}
