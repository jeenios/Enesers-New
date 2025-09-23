<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function purchaseReturnMultiple()
    {
        return $this->belongsTo(PurchaseReturn::class, 'purchase_return_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
