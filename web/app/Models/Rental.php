<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    //
    protected $fillable = [
        'name',
        'number_of_rooms',
        'description',
        'property_address',
        'is_active',
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
    public function activeStatus()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    // public function caretakers()
    // {
    //     return $this->hasManyThrough(Caretaker::class, Room::class);
    // }
    public function caretakers()
    {
        return $this->hasMany(Caretaker::class);
    }
}
