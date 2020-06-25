<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserFullResource extends Resource
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
            'user_id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' =>$this->last_name,
            'email' => $this->email,
            'email_confirmed' => $this->email_verified,
            'phone' => $this->mobile,
            'api_token' => $this->api_token,
            '3d_model' => $this->ThreeD_model,
            //'shipping_address' => new AddressResource($this->shippingAddress),
            //'cart' => new CartResource($this->cart),
            //'order'=> new CartResource($this->orders),
            //'billing_address' => new AddressResource($this->billingAddress),
            'member_since' => $this->created_at->format('l jS \\of  F Y'),



        ];
    }
}
