<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
     protected $fillable = [
        'outlet_name',
        'location',
        'contact_number', ];

//Relationships

public function users()
    {
        return $this->hasMany(User::class);
    }


    public function foods()
    {
        return $this->hasMany(Food::class);
    }


    public function counters()
    {
        return $this->hasMany(Counter::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
