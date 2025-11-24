<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = [
        'room_name',
        'description',
        'monthly_rent',
        'security_deposit',
        'other_charges',
        'maximum_capacity',
        'is_vacant',
        'is_active',
        'rental_id',
        'created_by',
        'updated_by',
    ];
    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function occupants()
    {
        return $this->hasMany(Tenant::class);
    }
    public function vacantStatus()
    {
        return $this->is_vacant ? 'Vacant' : 'Occupied';
    }
    public function activeStatus()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
}
