<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SalesOrder extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
        'transaction_at' => 'datetime',
        'estimate_at' => 'datetime',
    ];

    protected $guarded = [
        'id',
    ];

    public function salesOrderMultiple()
    {
        return $this->hasMany(SalesOrderMultiple::class, 'sales_order_id');
    }

    public function salesOrderLines()
    {
        return $this->hasMany(SalesOrderMultiple::class)
            ->where('type', 'line_item');
    }

    public function salesOrderDownPayments()
    {
        return $this->hasMany(SalesOrderMultiple::class)
            ->where('type', 'down_payment');
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

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }

    public function salesPricelist()
    {
        return $this->belongsTo(SalesPricelist::class);
    }

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function currencyShipment()
    {
        return $this->belongsTo(Currency::class, 'currency_shipment_id');
    }

    public function currencyBill()
    {
        return $this->belongsTo(Currency::class, 'currency_bill_id');
    }

    public function currencyCompany()
    {
        return $this->belongsTo(Currency::class, 'currency_company_id');
    }

    public function currencyFrom()
    {
        return $this->belongsTo(Currency::class, 'currency_from_id');
    }

    public function multiples()
    {
        return $this->hasMany(PurchaseOrderMultiple::class);
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
