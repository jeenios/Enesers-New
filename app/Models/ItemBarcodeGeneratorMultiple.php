<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBarcodeGeneratorMultiple extends Model
{
    protected $table = 'item_barcodegenerator_multiple';

    protected $fillable = [
        'item_id',
        'item_barcodegenerator_id',
        'description_barcode',
        'quantity_barcode',
        'price_barcode',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function barcodeGenerator()
    {
        return $this->belongsTo(ItemBarcodeGenerator::class, 'item_barcodegenerator_id');
    }
}
