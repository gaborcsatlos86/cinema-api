<?php

namespace App\Actions;

use App\Models\Room;
use App\DataTransferObjects\RoomStoreDTO;

class RoomUpdateAction
{
    public function execute(RoomStoreDTO $roomStoreDTO, Room $room): Room
    {
        $room->update([
            'title' => $roomStoreDTO->title,
            'capacity' => $roomStoreDTO->capacity
        ]);
        
        return $room;
    }
}
