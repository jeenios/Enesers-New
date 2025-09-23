<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Hospital extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->code)) {
                $lastRecord = static::orderBy('id', 'desc')->first();

                if (!$lastRecord || empty($lastRecord->code)) {
                    $number = 1;
                } else {
                    $number = (int) substr($lastRecord->code, 2) + 1;
                }

                $model->code = 'WR' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
