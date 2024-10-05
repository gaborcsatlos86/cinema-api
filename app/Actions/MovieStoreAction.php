<?php

namespace App\Actions;

use App\Models\Movie;
use App\DataTransferObjects\MovieStoreDTO;

class MovieStoreAction
{
    public function execute(MovieStoreDTO $movieStoreDTO): Movie
    {
        if ($movieStoreDTO->coverImage !== null) {
            $path = $movieStoreDTO->coverImage->store('coverImages');
        }
        
        $movie = Movie::create([
            'title' => $movieStoreDTO->title,
            'description' => $movieStoreDTO->description,
            'ageLimit' => $movieStoreDTO->ageLimit,
            'lang' => $movieStoreDTO->lang,
            'coverImage' => $path ?? null
        ]);
        
        return $movie;
    }
}
