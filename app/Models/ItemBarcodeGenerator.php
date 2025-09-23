<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ItemBarcodeGenerator extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function salesPricelist()
    {
        return $this->belongsTo(SalesPricelist::class);
    }

    public function barcodeMultiples()
    {
        return $this->hasMany(
            ItemBarcodeGeneratorMultiple::class,
            'item_barcodegenerator_id',
            'id'
        );
    }
}
