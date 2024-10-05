<?php

namespace App\Actions;

use App\Models\Room;
use App\DataTransferObjects\RoomStoreDTO;

class RoomStoreAction
{
    public function execute(RoomStoreDTO $roomStoreDTO): Room
    {
        $room = Room::create([
            'title' => $roomStoreDTO->title,
            'capacity' => $roomStoreDTO->capacity
        ]);
        
        return $room;
    }
}
