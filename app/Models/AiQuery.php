<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiQuery extends Model
{
    protected $table = 'ai_query';


    protected $fillable = [
        'user_id',
        'query',
        'response',
    ];


    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
