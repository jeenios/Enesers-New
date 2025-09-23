<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SalesPricelist extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'state',
        'name',
        'description',
        'currency_id',
        'default',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function itemBarcodegenerator()
    {
        return $this->hasMany(ItemBarcodeGenerator::class);
    }

    public function itemSalesPriceEntries()
    {
        return $this->hasMany(ItemSalesPriceEntry::class);
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
