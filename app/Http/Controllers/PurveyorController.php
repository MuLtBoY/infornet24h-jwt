<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purveyor\PurveyorDestroyRequest;
use App\Http\Requests\Purveyor\PurveyorSearchRequest;
use App\Http\Requests\Purveyor\PurveyorShowRequest;
use App\Http\Requests\Purveyor\PurveyorStoreRequest;
use App\Http\Requests\Purveyor\PurveyorUpdateRequest;
use App\Http\Resources\PurveyorResource;
use App\Http\Resources\PurveyorWithMetricsResource;
use App\Services\Purveyor\PurveyorSearchService;
use App\Services\Purveyor\PurveyorService;
use Illuminate\Http\JsonResponse;
use Throwable;

class PurveyorController extends Controller
{
    public function __construct(protected PurveyorService $purveyorService) {}

    public function store(PurveyorStoreRequest $request): JsonResponse
    {
        $createdResource = [];
        try {
            $created = $this->purveyorService->create($request->validated());
            $createdResource = ['purveyor' => new PurveyorResource($created)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($createdResource, 'criar prestador');
    }

    public function show(PurveyorShowRequest $request): JsonResponse
    {
        $purveyorResource = [];
        try {
            $purveyor = $this->purveyorService->getById($request->validated());
            $purveyorResource = ['purveyor' => new PurveyorResource($purveyor)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($purveyorResource, 'buscar prestador');
    }

    public function update(PurveyorUpdateRequest $request): JsonResponse
    {
        $updatedResource = [];
        try {
            $updated = $this->purveyorService->update($request->validated());
            $updatedResource = ['purveyor' => new PurveyorResource($updated)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($updatedResource, 'atualizar prestador');
    }

    public function destroy(PurveyorDestroyRequest $request): JsonResponse
    {
        try {
            $this->purveyorService->delete($request->validated());

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse([], 'excluir prestador');
    }

    public function search(PurveyorSearchRequest $request): JsonResponse
    {
        $purveyorsResource = [];
        try {
            $purveyors = app(PurveyorSearchService::class)->handle($request->validated());
            $purveyorsResource = ['purveyors' => PurveyorWithMetricsResource::collection($purveyors)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($purveyorsResource, 'buscar prestadores');
    }
}