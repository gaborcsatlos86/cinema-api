<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\MovieScreeningStoreDTO;
use App\Http\Requests\MovieScreeningStoreRequest;
use App\Actions\{MovieScreeningStoreAction, MovieScreeningUpdateAction};
use Illuminate\Http\{JsonResponse};
use App\Models\{MovieScreening, Room, Movie};
use OpenApi\Attributes as OA;


class MovieScreeningController extends Controller
{
    #[OA\Get(
        path: '/movie-screenings',
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get the list of movie screening',
        tags: ['Movie Screening']
    )]
    public function index(): JsonResponse
    {
        return parent::index();
    }
    
    #[OA\Get(
        path: '/movie-screenings/create',
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get the input info for create movie screening',
        tags: ['Movie Screening']
    )]
    public function create(): JsonResponse
    {
        return parent::create();
    }
    
    #[OA\Post(
        path: '/movie-screenings',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ['movie_id', 'room_id', 'start', 'free_positions'],
                    properties: [
                        new OA\Property(property: 'movie_id', type: 'integer'),
                        new OA\Property(property: 'room_id', type: 'integer'),
                        new OA\Property(property: 'start', type: 'datetime'),
                        new OA\Property(property: 'free_positions', type: 'integer'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'OK'),
            new OA\Response(response: 422, description: 'Some error'),
        ],
        description: 'Post endpoint to create new movie screening',
        tags: ['Movie Screening']
    )]
    public function store(MovieScreeningStoreRequest $request, MovieScreeningStoreAction $action): JsonResponse
    {
        $room = Room::find($request->room_id);
        $movie = Movie::find($request->movie_id);
        if ($room == null || $movie == null) {
            return response()->json(['errors' => 'Wrong connection id (room or movie)'], 422);
        }
        
        if ($request->free_positions < 0 || ($request->free_positions > $room->capacity)) {
            return response()->json(['errors' => 'Wrong free position number'], 422);
        }
        $movieScreening = $action->execute($request->toDTO());
        return response()->json($movieScreening, 201);
    }
    
    #[OA\Get(
        path: '/movie-screenings/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get a movie screening data by id',
        tags: ['Movie Screening']
    )]
    public function show($id): JsonResponse
    {
        return parent::show($id);
    }
    
    #[OA\Get(
        path: '/movie-screenings/{id}/edit',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get a movie screening edit form inputs',
        tags: ['Movie Screening']
    )]
    public function edit($id): JsonResponse
    {
        return parent::edit($id);
    }
    
    #[OA\Put(
        path: '/movie-screenings/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ['movie_id', 'room_id', 'start', 'free_positions'],
                    properties: [
                        new OA\Property(property: 'movie_id', type: 'integer'),
                        new OA\Property(property: 'room_id', type: 'integer'),
                        new OA\Property(property: 'start', type: 'datetime'),
                        new OA\Property(property: 'free_positions', type: 'integer'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 422, description: 'Some error'),
        ],
        description: 'Modify a created movie screening',
        tags: ['Movie Screening']
    )]
    public function update(MovieScreeningStoreRequest $request, MovieScreeningUpdateAction $action, $id): JsonResponse
    {
        $movieScreening = $this->findItem($id);
        if ($request->free_positions < 0 || ($request->free_positions > $movieScreening->room->capacity)) {
            return response()->json(['errors' => 'Wrong free position number'], 422);
        }
        
        $movieScreening = $action->execute($request->toDTO(), $movieScreening);
        return response()->json($movieScreening, 200);
    }
    
    #[OA\Delete(
        path: '/movie-screenings/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 204, description: 'OK'),
            new OA\Response(response: 422, description: 'Some error'),
        ],
        description: 'Remove a movie from db',
        tags: ['Movie Screening']
    )]
    public function destroy($id): JsonResponse
    {
        return parent::destroy($id);
    }
    
    protected function getModelClass(): string
    {
        return MovieScreening::class;
    }
    
    protected function getItemStruct(): array
    {
        return MovieScreeningStoreDTO::getKeys();
    }
}
