<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StockTransfer extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    public function stockTransferMultiple()
    {
        return $this->hasMany(StockTransferMultiple::class, 'stock_transfer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bussinessUnit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function salesPriceList()
    {
        return $this->belongsTo(SalesPricelist::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function currencyWarehouse()
    {
        return $this->belongsTo(Currency::class, 'currency_warehouse_id');
    }

    public function currencyDestination()
    {
        return $this->belongsTo(Currency::class, 'currency_destination_id');
    }

    public function currencyCompany()
    {
        return $this->belongsTo(Currency::class, 'currency_company_id');
    }

    public function purchaseRequisition()
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }
}
