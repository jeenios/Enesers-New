<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisitionTemplateMultiple extends Model
{
    protected $fillable = [
        'item_id',
        'unit_id',
        'purchase_requisitiontemplate_id',
        'description_barcode',
        'quantity_barcode',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function purchaseRequisitionTemplate()
    {
        return $this->belongsTo(PurchaseRequisitionTemplate::class, 'purchase_requisitiontemplate_id');
    }
}
