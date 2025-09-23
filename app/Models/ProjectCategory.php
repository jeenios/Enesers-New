<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProjectCategory extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'parent_category',
        'name',
        'description',
    ];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
