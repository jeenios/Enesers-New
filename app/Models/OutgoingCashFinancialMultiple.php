<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingCashFinancialMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function outgoingCashPaymentMultiple()
    {
        return $this->belongsTo(OutgoingCashFinancial::class, 'outgoing_cash_financial_id');
    }

    public function financialReason()
    {
        return $this->belongsTo(FinancialReason::class, 'financial_reason_id');
    }
}
