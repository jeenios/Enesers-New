<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransferMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function stockTransferMultiple()
    {
        return $this->belongsTo(StockTransfer::class, 'stock_transfer_id');
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
