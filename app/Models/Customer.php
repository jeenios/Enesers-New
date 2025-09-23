<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'address' => 'array',
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
        'payment_term_id',
        'user_id',
        'customer_category',
        'sales_pricelist_id',
        'tax',
        'tax_name',
        'tax_number',
        'credit_limit',
        'grace_period',
        'address',
        'contact',
        'receivable_account',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesPricelist()
    {
        return $this->belongsTo(SalesPricelist::class);
    }

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }
}
