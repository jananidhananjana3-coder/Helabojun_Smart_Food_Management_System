<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'type',
        'data',
        'read_at',
    ];


    // Relationships

    public function notifiable()
    {
        return $this->morphTo();
    }
}