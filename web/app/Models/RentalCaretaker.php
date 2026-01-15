<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalCaretaker extends Model
{
    protected $fillable = [
        'rental_id',
        'caretaker_id',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function caretaker()
    {
        return $this->belongsTo(Caretaker::class);
    }
}
