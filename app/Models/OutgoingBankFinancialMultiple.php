<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingBankFinancialMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function outgoingBankPaymentMultiple()
    {
        return $this->belongsTo(OutgoingBankFinancial::class, 'outgoing_bank_financial_id');
    }

    public function financialReason()
    {
        return $this->belongsTo(FinancialReason::class, 'financial_reason_id');
    }
}
