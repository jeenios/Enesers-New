<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Currency extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'state',
        'name',
        'rounding_precision',
    ];

    public function salesPricelists()
    {
        return $this->hasMany(SalesPricelist::class);
    }
}
