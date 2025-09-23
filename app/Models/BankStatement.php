<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BankStatement extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function financialAccount()
    {
        return $this->belongsTo(FinancialAccount::class);
    }
}
