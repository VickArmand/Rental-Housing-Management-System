<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalDue extends Model
{
    //
    protected $fillable = [
        'rental_id',
        'tenant_id',
        'room_id',
        'due_type',
        'description',
        'original_amount',
        'amount_paid',
        'amount_due',
        'due_date',
        'status',
        'created_by',
        'updated_by',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
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
