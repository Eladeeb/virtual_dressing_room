<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $fillable = [
        'user_id','name'
        , 'email',
        'street_number'
        ,'postcode'
        ,'commune'
        ,'street_number',
        'city', 'village'
        ,'district'
        ,'phone'
    ];
}
