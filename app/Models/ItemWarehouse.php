<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemWarehouse extends Model
{
    protected $table = 'item_warehouse';

    protected $fillable = [
        'item_id',
        'warehouse_id',
        'minimum_quantity',
        'maximum_quantity',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
