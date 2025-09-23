<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingCashPaymentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function incomingCashPaymentMultiple()
    {
        return $this->belongsTo(IncomingCashPayment::class, 'incoming_cash_payment_id');
    }

    public function financialReason()
    {
        return $this->belongsTo(FinancialReason::class, 'financial_reason_id');
    }
}
