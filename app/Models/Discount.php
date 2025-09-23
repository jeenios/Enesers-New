<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Discount extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function discountMultiple()
    {
        return $this->hasMany(DiscountMultiple::class, 'discount_id');
    }

    public function multiples()
    {
        return $this->hasMany(DiscountMultiple::class, 'discount_id');
    }
}
