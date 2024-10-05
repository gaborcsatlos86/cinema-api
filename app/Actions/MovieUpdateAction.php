<?php

namespace App\Actions;

use App\Models\Movie;
use App\DataTransferObjects\MovieStoreDTO;

class MovieUpdateAction
{
    public function execute(MovieStoreDTO $movieStoreDTO, Movie $movie): Movie
    {
        if ($movieStoreDTO->coverImage !== null) {
            $path = $movieStoreDTO->coverImage->store('coverImages');
        }
        
        $movie->update([
            'title' => $movieStoreDTO->title,
            'description' => $movieStoreDTO->description,
            'ageLimit' => $movieStoreDTO->ageLimit,
            'lang' => $movieStoreDTO->lang,
            'coverImage' => $path ?? null
        ]);
        
        return $movie;
    }
}
