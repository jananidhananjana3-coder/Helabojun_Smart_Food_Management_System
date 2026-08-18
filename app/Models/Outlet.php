<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_name',
        'location',
        'contact_number',
        'google_maps_url',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getMapOpenUrlAttribute(): ?string
    {
        $value = $this->google_maps_url ?: $this->location;

        if (!$value) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_URL)
            ? $value
            : 'https://www.google.com/maps/search/?api=1&query='
                . urlencode($value);
    }

    public function getMapEmbedUrlAttribute(): ?string
    {
        if (!$this->google_maps_url && !$this->location) {
            return null;
        }

        if (
            $this->google_maps_url &&
            str_contains(
                $this->google_maps_url,
                'maps/embed'
            )
        ) {
            return $this->google_maps_url;
        }

        $query = $this->google_maps_url ?: $this->location;

        return 'https://www.google.com/maps?q='
            . urlencode($query)
            . '&output=embed';
    }
}