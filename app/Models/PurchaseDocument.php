<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class PurchaseDocument extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    protected static function booted()
    {
        // Auto isi field dari PurchaseOrder jika belum ada
        static::creating(function ($model) {
            if ($model->purchase_order_id && ! $model->company_id) {
                $po = \App\Models\PurchaseOrder::find($model->purchase_order_id);
                if ($po) {
                    $model->company_id   = $po->company_id;
                    $model->vendor_id    = $po->vendor_id;
                    $model->warehouse_id = $po->warehouse_id;
                }
            }

            // Auto generate code
            if (! $model->code) {
                $model->code = 'PD' . strtoupper(Str::random(4));
            }
        });
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseDocument::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
