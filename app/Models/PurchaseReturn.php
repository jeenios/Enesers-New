<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurchaseReturn extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    public function purchaseReturnMultiple()
    {
        return $this->hasMany(PurchaseReturnMultiple::class, 'purchase_return_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bussinessUnit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function currencyFrom()
    {
        return $this->belongsTo(Currency::class, 'currency_from_id');
    }

    public function currencyShipment()
    {
        return $this->belongsTo(Currency::class, 'currency_shipment_id');
    }

    public function currencyCompany()
    {
        return $this->belongsTo(Currency::class, 'currency_company_id');
    }

    public function multiples()
    {
        return $this->hasMany(PurchaseReturnMultiple::class);
    }
}
