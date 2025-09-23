<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SalesTarget extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function salesTargetMultiple()
    {
        return $this->hasMany(SalesTargetMultiple::class, 'salestarget_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouseCategory()
    {
        return $this->belongsTo(WarehouseCategory::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
