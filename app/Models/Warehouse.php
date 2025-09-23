<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Warehouse extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'state',
        'name',
        'warehouse_category_id',
        'warehouse_allow',
        'description',
        'address_type',
        'contact_person_name',
        'contact_person_phone',
        'address',
        'country_code',
        'postcode',
        'sales_account',
        'sales_return_account',
        'sales_discount_account',
        'sales_commission_account',
        'sales_gross_account',
    ];

    public function warehouseCategory()
    {
        return $this->belongsTo(WarehouseCategory::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_warehouse')
            ->withPivot('minimum_quantity', 'maximum_quantity')
            ->withTimestamps();
    }
}
