<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'outlet_id',
        'counter_name',
        'counter_number',
        'status',   
    ];


    // Relationships

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function users()
    {
    return $this->hasMany(User::class);
    }
}
