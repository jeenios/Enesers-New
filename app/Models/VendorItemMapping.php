<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class VendorItemMapping extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function vendorItemMappingMultiple()
    {
        return $this->hasMany(VendorItemMappingMultiple::class, 'vendoritemmapping_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
