<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CityResource extends Resource
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
            'city_id' => $this->id,
            'city_name' => $this->name,


        ];
    }
}