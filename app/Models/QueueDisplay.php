<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueDisplay extends Model
{
    protected $fillable = [
        'order_id',
        'queue_number',
        'status',
    ];


    // Relationships

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}