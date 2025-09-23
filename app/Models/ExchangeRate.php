<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExchangeRate extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'state',
        'currency_id',
        'rate',
        'effective_at',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
