<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkReport extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($report) {
            $report->user_id = auth()->id();
        });
    }

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

                $model->code = 'RS' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }

            if (auth()->check() && empty($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    }
}
