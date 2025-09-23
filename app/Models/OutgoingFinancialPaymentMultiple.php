<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingFinancialPaymentMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function outgoingFinancialPaymentMultiple()
    {
        return $this->belongsTo(OutgoingFinancialPayment::class, 'outgoing_financial_payment_id');
    }

    public function financialReason()
    {
        return $this->belongsTo(FinancialReason::class, 'financial_reason_id');
    }
}
