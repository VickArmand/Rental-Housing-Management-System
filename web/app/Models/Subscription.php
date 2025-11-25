<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    protected $fillable = [
        'name',
        'duration_days',
        'price',
        'created_by',
        'updated_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
