<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseQuotationMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function purchaseQuotationMultiple()
    {
        return $this->belongsTo(PurchaseQuotation::class, 'purchase_quotation_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
