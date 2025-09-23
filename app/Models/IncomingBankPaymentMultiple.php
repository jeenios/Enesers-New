<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingBankPaymentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function incomingBankPaymentMultiple()
    {
        return $this->belongsTo(IncomingBankPayment::class, 'incoming_bank_payment_id');
    }

    public function financialReason()
    {
        return $this->belongsTo(FinancialReason::class, 'financial_reason_id');
    }
}
