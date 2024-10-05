<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\RoomStoreDTO;
use App\Http\Requests\RoomStoreRequest;
use App\Actions\{RoomStoreAction, RoomUpdateAction};
use Illuminate\Http\JsonResponse;
use App\Models\Room;
use OpenApi\Attributes as OA;


class RoomController extends Controller
{
    #[OA\Get(
        path: '/rooms',
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get a list of rooms',
        tags: ['Room']
    )]
    public function index(): JsonResponse
    {
        return parent::index();
    }
    
    #[OA\Get(
        path: '/rooms/create',
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get the input info for create room',
        tags: ['Room']
    )]
    public function create(): JsonResponse
    {
        return parent::create();
    }
    
    #[OA\Post(
        path: '/rooms',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ['title', 'capacity'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string'),
                        new OA\Property(property: 'capacity', type: 'integer'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'OK'),
        ],
        description: 'Post endpoint to create new room',
        tags: ['Room']
    )]
    public function store(RoomStoreRequest $request, RoomStoreAction $action): JsonResponse
    {
        $room = $action->execute($request->toDTO());
        return response()->json($room, 201);
    }
    
    #[OA\Get(
        path: '/rooms/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get a room data by id',
        tags: ['Room']
    )]
    public function show($id): JsonResponse
    {
        return parent::show($id);
    }
    
    #[OA\Get(
        path: '/rooms/{id}/edit',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Get a room edit form inputs',
        tags: ['Room']
    )]
    public function edit($id): JsonResponse
    {
        return parent::edit($id);
    }
    
    #[OA\Put(
        path: '/rooms/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ['title', 'capacity'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string'),
                        new OA\Property(property: 'capacity', type: 'integer'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ],
        description: 'Modify a created room',
        tags: ['Room']
    )]
    public function update(RoomStoreRequest $request, RoomUpdateAction $action, $id): JsonResponse
    {
        $room = $action->execute($request->toDTO(), $this->findItem($id));
        return response()->json($room, 200);
    }
    
    #[OA\Delete(
        path: '/rooms/{id}',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 204, description: 'OK'),
            new OA\Response(response: 422, description: 'Some error'),
        ],
        description: 'Remove a room from db',
        tags: ['Room']
    )]
    public function destroy($id): JsonResponse
    {
        $room = $this->findItem($id);
        foreach ($room->movieScreenings as $movieScreening) {
            if ($movieScreening->free_positions < $room->capacity) {
                return response()->json(['errors' => 'This item is not deletable'], 422);
            }
        }
        Room::destroy($id);
        return response()->json(null, 204);
    }
    
    protected function getModelClass(): string
    {
        return Room::class;
    }
    
    protected function getItemStruct(): array
    {
        return RoomStoreDTO::getKeys();
    }
}
