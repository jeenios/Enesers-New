<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkListMultiple extends Model
{
    protected $guarded = [
        'id'
    ];

    public function workListMultiple()
    {
        return $this->belongsTo(WorkList::class, 'work_list_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
