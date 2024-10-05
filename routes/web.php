<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{MovieController, RoomController, MovieScreeningController};

Route::resources([
    'movies' => MovieController::class,
    'rooms' => RoomController::class,
    'movie-screenings' => MovieScreeningController::class
]);