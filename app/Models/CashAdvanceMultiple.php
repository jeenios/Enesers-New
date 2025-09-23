<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashAdvanceMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function cashAdvanceMultiple()
    {
        return $this->belongsTo(CashAdvance::class, 'cash_advance_id');
    }

    public function cashAdvanceReason()
    {
        return $this->belongsTo(CashAdvanceReason::class, 'cash_advance_reason_id');
    }
}
