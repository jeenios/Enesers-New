<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BusinessUnit extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'state',
        'name',
        'description',
        'business_unit_category_id',
    ];

    public function businessUnitCategory()
    {
        return $this->hasMany(BusinessUnitCategory::class);
    }
}
