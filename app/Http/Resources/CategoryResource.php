<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CategoryResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'category_id' => $this->id,
            'name'=>$this->name ,
            'description' => $this->description,
            'image' => $this->url,
            'parent_id'=>$this->parent_id
        ];
    }
}
