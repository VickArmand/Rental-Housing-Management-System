<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    //
    protected $fillable = [
        'first_name',
        'middle_name',
        'surname',
        'identification_number',
        'phone_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'user_id',
        'is_forbidden',
        'forbidden_reason',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
