<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalIncome extends Model
{
    //
    protected $fillable = [
        'rental_id',
        'income_type',
        'description',
        'tenant_id',
        'room_id',
        'owner_id',
        'income_reference',
        'payment_method',
        'status',
        'payment_date',
        'original_amount',
        'amount_received',
        'balance_due',
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
