<?php

namespace App\Http\Controllers;

use Illuminate\Http\{JsonResponse};

abstract class Controller
{
    public function index(): JsonResponse
    {
        $items = $this->getAllItem();
        return response()->json($items);
    }
    
    public function create(): JsonResponse
    {
        $itemStruct = $this->getItemStruct();
        return response()->json($itemStruct);
    }
    
    public function show($id): JsonResponse
    {
        $item = $this->findItem($id);
        return response()->json($item);
    }
    
    public function edit($id): JsonResponse
    {
        $item = $this->findItem($id);
        return response()->json($item);
    }
    
    public function destroy($id): JsonResponse
    {
        $modelClassName = $this->getModelClass();
        $modelClassName::destroy($id);
        return response()->json(null, 204);
    }
    
    protected function findItem($id)
    {
        $modelClassName = $this->getModelClass();
        return $modelClassName::find($id);
    }
    
    protected function getAllItem()
    {
        $modelClassName = $this->getModelClass();
        return $modelClassName::all();
    }
    
    abstract protected function getModelClass(): string;
    
    abstract protected function getItemStruct(): array;
    
}
