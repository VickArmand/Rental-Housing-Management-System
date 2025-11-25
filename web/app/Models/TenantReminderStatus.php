<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantReminderStatus extends Model
{
    //
    protected $fillable = [
        'tenant_reminder_id',
        'status',
        'acknowledged_at',
        'dismissed_at',
        'sent_at',
        'created_by',
        'updated_by',
    ];
    public function reminder()
    {
        return $this->belongsTo(TenantReminder::class);
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
