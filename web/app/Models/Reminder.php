<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'type',
        'priority',
        'start_date',
        'end_date',
        'is_active',
        'repeat_interval_days',
        'remind_time',
        'owner_id',
        'created_by',
        'updated_by',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
