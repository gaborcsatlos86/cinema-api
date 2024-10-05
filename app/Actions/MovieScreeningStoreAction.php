<?php

namespace App\Actions;

use App\Models\MovieScreening;
use App\DataTransferObjects\MovieScreeningStoreDTO;

class MovieScreeningStoreAction
{
    public function execute(MovieScreeningStoreDTO $movieScreeningStoreDTO): MovieScreening
    {
        $movieScreening = MovieScreening::create([
            'movie_id' => $movieScreeningStoreDTO->movie_id,
            'room_id' => $movieScreeningStoreDTO->room_id,
            'start' => $movieScreeningStoreDTO->start,
            'free_positions' => $movieScreeningStoreDTO->free_positions
        ]);
        
        return $movieScreening;
    }
}
