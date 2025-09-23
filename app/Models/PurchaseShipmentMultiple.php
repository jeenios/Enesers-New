<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseShipmentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function purchaseShipmentMultiple()
    {
        return $this->belongsTo(PurchaseShipment::class, 'purchase_shipment_id');
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
