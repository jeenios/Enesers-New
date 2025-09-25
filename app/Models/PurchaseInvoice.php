<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurchaseInvoice extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function purchaseInvoiceMultiple()
    {
        return $this->hasMany(PurchaseInvoiceMultiple::class, 'purchase_invoice_id');
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
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
}
