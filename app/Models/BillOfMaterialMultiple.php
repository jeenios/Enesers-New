<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillOfMaterialMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function billOfMaterialMultiple()
    {
        return $this->belongsTo(BillOfMaterial::class, 'bill_of_material_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
