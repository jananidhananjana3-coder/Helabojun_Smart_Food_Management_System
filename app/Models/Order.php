<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [

        'total_amount' => 'decimal:2',

        'discount' => 'decimal:2',

        'grand_total' => 'decimal:2',

        'cash_received' => 'decimal:2',

        'change_amount' => 'decimal:2',
    ];


    /*
    |--------------------------------------------------------------------------
    | User / Cashier
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Outlet
    |--------------------------------------------------------------------------
    */

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Counter
    |--------------------------------------------------------------------------
    */

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Order Items
    |--------------------------------------------------------------------------
    */

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Kitchen Ticket
    |--------------------------------------------------------------------------
    */

    public function kitchenTicket()
    {
        return $this->hasOne(KitchenTicket::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Queue
    |--------------------------------------------------------------------------
    */

    public function queueDisplay()
    {
        return $this->hasOne(QueueDisplay::class);
    }
}