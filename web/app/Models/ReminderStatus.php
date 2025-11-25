<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderStatus extends Model
{
    //
    protected $fillable = [
        'reminder_id',
        'status',
        'acknowledged_at',
        'dismissed_at',
        'sent_at',
        'created_by',
        'updated_by',
    ];

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
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
