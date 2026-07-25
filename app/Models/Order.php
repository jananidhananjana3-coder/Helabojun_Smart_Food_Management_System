<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'outlet_id',
        'token_number',
        'total_amount',
        'status',
        'payment_status',
    ];


    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function payment()
    {
        return $this->hasOne(Payment::class);
    }


    public function kitchenTicket()
    {
        return $this->hasOne(KitchenTicket::class);
    }


    public function queueDisplay()
    {
        return $this->hasOne(QueueDisplay::class);
    }
}
