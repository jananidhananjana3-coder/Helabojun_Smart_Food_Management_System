<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Outlet;
use App\Models\Counter;
use App\Models\Order;
use App\Models\KitchenTicket;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'nic_number',
        'birthday',
        'address',
        'join_date',
        'role',
        'outlet_id',
        'counter_id',
        'training_period',
        'food_specialties',
        'profile_image',
        'verification_code',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthday' => 'date',
        'join_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | OUTLET
    |--------------------------------------------------------------------------
    */

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /*
    |--------------------------------------------------------------------------
    | COUNTER
    |--------------------------------------------------------------------------
    */

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | KITCHEN TICKETS
    |--------------------------------------------------------------------------
    */

    public function kitchenTickets()
    {
        return $this->hasMany(
            KitchenTicket::class,
            'chef_id'
        );
    }
}