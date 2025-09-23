<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurchaseDocumentMultiple extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    public function purchaseDocument()
    {
        return $this->belongsTo(PurchaseDocument::class);
    }

    public function purchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
