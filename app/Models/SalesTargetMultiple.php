<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTargetMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function salesTargetMultiple()
    {
        return $this->belongsTo(SalesTarget::class, 'salestarget_id');
    }
}
