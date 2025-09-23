<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Project extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'image' => 'array',
    ];

    protected $guarded = [
        'id',
    ];

    public function projectMultiples()
    {
        return $this->hasMany(ProjectMultiple::class, 'project_id');
    }

    public function incomes()
    {
        return $this->hasMany(ProjectMultiple::class, 'project_id')
            ->where('type', 'income');
    }

    public function expenses()
    {
        return $this->hasMany(ProjectMultiple::class, 'project_id')
            ->where('type', 'expense');
    }

    public function projectCategory()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
