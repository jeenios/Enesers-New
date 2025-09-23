<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTakeMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function stockTakeMultiple()
    {
        return $this->belongsTo(StockTake::class, 'stock_take_id');
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
