<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Error extends Model
{
    //
    protected $fillable = [
        'source',
        'data',
        'error_type',
        'error_message',
        'resolved',
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

    public function saveError(String $source, Array $data, String $error_type, String $error_message)
    {
        $this->source = $source;
        $this->data = json_encode($data);
        $this->error_type = $error_type;
        $this->error_message = $error_message;
        $this->resolved = false;
        $this->created_by = Auth::user()->id ?? null;
        $this->updated_by = Auth::user()->id ?? null;
        return $this->save();
    }

}
