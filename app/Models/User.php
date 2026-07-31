<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;



    protected $fillable = [

        'name',
        'email',
        'password',
        'phone',
        'role',
        'outlet_id',
        'counter_id',
        'verification_code'

    ];



    protected $hidden = [

        'password',
        'remember_token',

    ];



    protected $casts = [

        'email_verified_at' => 'datetime',
        'password' => 'hashed',

    ];



    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }



    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }



    public function orders()
    {
        return $this->hasMany(Order::class);
    }



    public function kitchenTickets()
    {
        return $this->hasMany(KitchenTicket::class,'chef_id');
    }

}