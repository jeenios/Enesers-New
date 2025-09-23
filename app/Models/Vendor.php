<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
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
        'payment_term_id',
        'vendor_category',
        'tax',
        'tax_name',
        'tax_number',
        'address',
        'contact',
        'payable_account',
        'image',
    ];

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }
}
