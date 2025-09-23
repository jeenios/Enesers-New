<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorItemMappingMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function vendorItemMappingMultiple()
    {
        return $this->belongsTo(VendorItemMapping::class, 'vendoritemmapping_id');
    }
}
