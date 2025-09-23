<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function salesOrderMultiple()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
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

    public function taxType()
    {
        return $this->belongsTo(Tax::class, 'tax_type_id');
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
