<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'outlet_id',
        'counter_id',
        'token_number',
        'order_type',
        'total_amount',
        'discount',
        'grand_total',
        'payment_method',
        'cash_received',
        'change_amount',
        'status',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function kitchenTickets()
    {
        return $this->hasMany(KitchenTicket::class);
    }

    public function queueDisplay()
    {
        return $this->hasOne(QueueDisplay::class);
    }
}