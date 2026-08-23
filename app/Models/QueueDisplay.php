<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueDisplay extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'counter_id',
        'kitchen_ticket_id',
        'queue_number',
        'status',
    ];

    // Queue item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Queue item belongs to a counter
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    // Queue item belongs to a kitchen ticket
    public function kitchenTicket()
    {
        return $this->belongsTo(
            KitchenTicket::class,
            'kitchen_ticket_id'
        );
    }
}