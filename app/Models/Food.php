<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
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


    // Relationships

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
}
