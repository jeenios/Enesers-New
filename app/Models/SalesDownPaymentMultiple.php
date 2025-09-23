<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDownPaymentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function salesDownPaymentMultiple()
    {
        return $this->belongsTo(SalesDownPayment::class, 'sales_down_payment_id');
    }
}
