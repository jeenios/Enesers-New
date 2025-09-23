<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'item_warehouse')
            ->using(ItemWarehouse::class)
            ->withPivot('minimum_quantity', 'maximum_quantity')
            ->withTimestamps();
    }

    public function itemWarehouses()
    {
        return $this->hasMany(ItemWarehouse::class);
    }

    public function itembarcodegenerators()
    {
        return $this->belongsToMany(ItemBarcodeGenerator::class, 'item_barcodegenerator_multiple')
            ->withPivot('description_barcode', 'quantity_barcode', 'price_barcode',)
            ->withTimestamps();
    }

    public function stockusage()
    {
        return $this->hasMany(StockUsage::class);
    }
}
