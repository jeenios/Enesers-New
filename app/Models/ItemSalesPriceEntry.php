<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ItemSalesPriceEntry extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function salesPricelist()
    {
        return $this->belongsTo(SalesPricelist::class);
    }

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
        return $this->hasMany(ItemSalesPriceEntryMultiple::class, 'item_salespriceentry_id');
    }
}
