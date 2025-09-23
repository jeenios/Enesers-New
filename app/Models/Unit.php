<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Unit extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'state',
        'name',
        'symbol',
        'description',
    ];

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
