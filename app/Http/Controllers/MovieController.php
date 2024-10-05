<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\MovieStoreDTO;
use App\Http\Requests\MovieStoreRequest;
use App\Actions\{MovieStoreAction, MovieUpdateAction};
use App\Models\Movie;
use Illuminate\Http\{JsonResponse};
use OpenApi\Attributes as OA;

#[OA\Info(title: 'cinema api endpints', version: '0.1')]
class MovieController extends Controller
{
    #[OA\Get(
        path: '/movies',
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get the list of movies',
        tags: ['Movie']
    )]
    public function index(): JsonResponse
    {
        return parent::index();
    }
    
    #[OA\Get(
        path: '/movies/create',
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get the input info for create movie',
        tags: ['Movie']
    )]
    public function create(): JsonResponse
    {
        return parent::create();
    }
    
    #[OA\Post(
        path: '/movies',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ['title', 'ageLimit', 'lang'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string'),
                        new OA\Property(property: 'description', type: 'string'),
                        new OA\Property(property: 'ageLimit', type: 'integer'),
                        new OA\Property(property: 'lang', type: 'string'),
                        new OA\Property(property: 'coverImage', type: 'file'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'OK'),
        ],
        description: 'Post edpoint to create new movie',
        tags: ['Movie']
    )]
    public function store(MovieStoreRequest $request, MovieStoreAction $action): JsonResponse
    {
        $movie = $action->execute($request->toDTO());
        return response()->json($movie, 201);
    }
    
    #[OA\Get(
        path: '/movies/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get a movie data by id',
        tags: ['Movie']
    )]
    public function show($id): JsonResponse
    {
        return parent::show($id);
    }
    
    #[OA\Get(
        path: '/movies/{id}/edit',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get a movie edit form inputs',
        tags: ['Movie']
    )]
    public function edit($id): JsonResponse
    {
        return parent::edit($id);
    }
    
    #[OA\Put(
        path: '/movies/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ['title', 'ageLimit', 'lang'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string'),
                        new OA\Property(property: 'description', type: 'string'),
                        new OA\Property(property: 'ageLimit', type: 'integer'),
                        new OA\Property(property: 'lang', type: 'string'),
                        new OA\Property(property: 'coverImage', type: 'file'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Modify a created movie',
        tags: ['Movie']
    )]
    public function update(MovieStoreRequest $request, MovieUpdateAction $action, $id): JsonResponse
    {
        $movie = $action->execute($request->toDTO(), $this->findItem($id));
        return response()->json($movie, 200);
    }
    
    #[OA\Delete(
        path: '/movies/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 204, description: 'OK'),
            new OA\Response(response: 422, description: 'Some error'),
        ],
        description: 'Remove a movie from db',
        tags: ['Movie']
    )]
    public function destroy($id): JsonResponse
    {
        $movie = $this->findItem($id);
        foreach ($movie->movieScreenings as $movieScreening) {
            if ($movieScreening->free_positions < $movieScreening->room->capacity) {
                return response()->json(['errors' => 'This item is not deletable'], 422);
            }
        }
        Movie::destroy($id);
        return response()->json(null, 204);
    }
    
    protected function getModelClass(): string
    {
        return Movie::class;
    }
    
    protected function getItemStruct(): array
    {
        return MovieStoreDTO::getKeys();
    }
}
