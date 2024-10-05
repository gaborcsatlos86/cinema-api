<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieScreening extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'movie_id',
        'room_id',
        'start',
        'free_positions'
    ];
    
    protected function casts(): array
    {
        return [
            'start' => 'datetime',
        ];
    }
    
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
