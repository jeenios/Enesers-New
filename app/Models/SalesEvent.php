<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SalesEvent extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function salesEventMultiple()
    {
        return $this->hasMany(SalesEventMultiple::class, 'salesevent_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function commission()
    {
        return $this->belongsTo(Commission::class);
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
