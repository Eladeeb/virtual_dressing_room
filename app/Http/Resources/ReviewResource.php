<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResource extends Resource
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
            'review_id' => $this->id,
            'stars'=>$this->stars,
            'review' => $this->review,
            'reviewer' => new UserResource($this->customer),
        ];
    }
}
