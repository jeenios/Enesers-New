<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurchaseInvoicePayment extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    public function purchaseInvoicePaymentMultiple()
    {
        return $this->hasMany(PurchaseInvoicePaymentMultiple::class, 'purchase_invoice_payment_id');
    }

    // 🔹 hanya invoice
    public function invoiceLines()
    {
        return $this->hasMany(PurchaseInvoicePaymentMultiple::class, 'purchase_invoice_payment_id')
            ->whereNotNull('purchase_invoice_id');
    }

    // 🔹 hanya financial
    public function financialLines()
    {
        return $this->hasMany(PurchaseInvoicePaymentMultiple::class, 'purchase_invoice_payment_id')
            ->whereNotNull('financial_reason');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bussinessUnit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }

    public function currencyBill()
    {
        return $this->belongsTo(Currency::class, 'currency_bill_id');
    }

    public function currencyCompany()
    {
        return $this->belongsTo(Currency::class, 'currency_company_id');
    }

    public function multiples()
    {
        return $this->hasMany(PurchaseInvoiceMultiple::class);
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }
}
