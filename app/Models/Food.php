<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'category_id',
        'outlet_id',
        'food_name',
        'description',
        'price',
        'image',
        'available_quantity',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function counters()
    {
        return $this->belongsToMany(
            Counter::class,
            'food_counter'
        )->withPivot('quantity')
         ->withTimestamps();
    }
}