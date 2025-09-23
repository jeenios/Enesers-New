<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustmentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function stockAdjustmentMultiple()
    {
        return $this->belongsTo(StockAdjustment::class, 'stock_adjustment_id');
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
