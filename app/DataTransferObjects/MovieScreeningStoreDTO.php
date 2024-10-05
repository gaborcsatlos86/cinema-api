<?php

namespace App\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;
use DateTimeImmutable;

class MovieScreeningStoreDTO extends DataTransferObject
{
    public int $movie_id;
    public int $room_id;
    public DateTimeImmutable $start;
    public int $free_positions;
    
    public static function getKeys(): array
    {
        return [
            'movie_id' => 'int',
            'room_id' => 'int',
            'start' => 'datetime',
            'free_positions' => 'int'
        ];
    }
}
