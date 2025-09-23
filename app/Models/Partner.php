<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Partner extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
        'contact' => 'array',
    ];

    protected $fillable = [
        'code',
        'state',
        'name',
        'description',
        'email',
        'website',
        'customer',
        'customer_payment_term',
        'user_id',
        'vendor',
        'vendor_payment_term',
        'partner_category_id',
        'sales_pricelist_id',
        'tax',
        'tax_name',
        'tax_number',
        'contact_number',
        'receivable_account',
        'payable_account',
        'image',
        'contact',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partnerCategory()
    {
        return $this->belongsTo(PartnerCategory::class);
    }

    public function salesPricelist()
    {
        return $this->belongsTo(SalesPricelist::class);
    }
}
