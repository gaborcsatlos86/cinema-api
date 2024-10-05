<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'description',
        'ageLimit',
        'lang',
        'coverImage'
    ];
    
    public function movieScreenings(): HasMany
    {
        return $this->hasMany(MovieScreening::class);
    }
}
