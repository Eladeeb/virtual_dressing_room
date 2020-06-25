<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable =[
        'street_name','street_number','city','village',
        'district','post_code','commune',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
