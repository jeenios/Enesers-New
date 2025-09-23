<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurchaseRequisitionTemplate extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function purchaseRequisitionTemplateMultiple()
    {
        return $this->hasMany(purchaseRequisitionTemplateMultiple::class, 'purchase_requisitiontemplate_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
