<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDownPaymentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function purchaseDownPaymentMultiple()
    {
        return $this->belongsTo(PurchaseDownPayment::class, 'purchase_down_payment_id');
    }
}
