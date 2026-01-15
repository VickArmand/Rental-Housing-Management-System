<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalOwner extends Model
{
    //
    protected $fillable = [
        'rental_id',
        'owner_id',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
