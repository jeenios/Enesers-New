<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PaymentMethod extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function financialAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'financial_account_id');
    }

    public function feeAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'fee_account_id');
    }
}
