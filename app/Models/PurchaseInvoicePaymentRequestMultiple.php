<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoicePaymentRequestMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function purchaseInvoicePaymentRequest()
    {
        return $this->belongsTo(PurchaseInvoicePaymentRequest::class, 'purchase_invoice_payment_request_id');
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }
}
