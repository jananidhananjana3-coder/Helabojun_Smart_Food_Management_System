<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenTicket extends Model
{
    protected $fillable = [
        'order_id',
        'chef_id',
        'status',
    ];


    // Relationships

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function chef()
    {
        return $this->belongsTo(User::class, 'chef_id');
    }
}
