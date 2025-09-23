<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function discountMultiple()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
