<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingFinancialPaymentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function incomingFinancialPaymentMultiple()
    {
        return $this->belongsTo(IncomingFinancialPayment::class, 'incoming_financial_payment_id');
    }

    public function financialReason()
    {
        return $this->belongsTo(FinancialReason::class, 'financial_reason_id');
    }
}
