<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoicePaymentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function purchaseInvoicePayment()
    {
        return $this->belongsTo(PurchaseInvoicePayment::class, 'purchase_invoice_payment_id');
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
