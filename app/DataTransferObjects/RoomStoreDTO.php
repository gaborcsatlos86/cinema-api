<?php

namespace App\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class RoomStoreDTO extends DataTransferObject
{
    public string $title;
    public int $capacity;
    
    public static function getKeys(): array
    {
        return [
            'title' => 'string',
            'capacity' => 'int',
        ];
    }
}
