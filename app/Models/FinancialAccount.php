<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FinancialAccount extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
