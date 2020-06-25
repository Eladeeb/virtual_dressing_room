<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $fillable=[
        'paymenr_id','invoice_id','amount_befor','platform_share','amount_after','line_total','product_id',
    ];
}
