<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockUsageMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function stockUsageMultiple()
    {
        return $this->belongsTo(StockUsage::class, 'stock_usage_id');
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
