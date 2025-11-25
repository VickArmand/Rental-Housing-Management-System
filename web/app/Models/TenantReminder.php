<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantReminder extends Model
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
        'tenant_id',
        'created_by',
        'updated_by',
    ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
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
