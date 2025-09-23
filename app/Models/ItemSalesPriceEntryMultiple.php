<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSalesPriceEntryMultiple extends Model
{
    protected $table = 'item_salespriceentry_multiple';

    protected $fillable = [
        'item_id',
        'unit_id',
        'item_salespriceentry_id',
        'description_barcode',
        'quantity_barcode',
        'price_barcode',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function itemSalesPriceEntries()
    {
        return $this->belongsTo(ItemSalesPriceEntry::class, 'item_salespriceentry_id');
    }
}
