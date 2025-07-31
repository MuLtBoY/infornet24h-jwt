<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assistance\AssistanceDestroyRequest;
use App\Http\Requests\Assistance\AssistanceShowRequest;
use App\Http\Requests\Assistance\AssistanceStoreRequest;
use App\Http\Requests\Assistance\AssistanceUpdateRequest;
use App\Http\Resources\AssistanceResource;
use App\Services\AssistanceService;
use Illuminate\Http\JsonResponse;
use Throwable;

class AssistanceController extends Controller
{
    public function __construct(protected AssistanceService $assistanceService) {}

    public function index(): JsonResponse
    {
        $dataResource = [];
        try {
            $data = $this->assistanceService->getAll();
            $dataResource = ['assistances' => AssistanceResource::collection($data)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($dataResource, 'listar serviços');
    }

    public function store(AssistanceStoreRequest $request): JsonResponse
    {
        $createdResource = [];
        try {
            $created = $this->assistanceService->create($request->validated());
            $createdResource = ['assistance' => new AssistanceResource($created)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($createdResource, 'criar serviço');
    }

    public function show(AssistanceShowRequest $request): JsonResponse
    {
        $assistanceResource = [];
        try {
            $assistance = $this->assistanceService->getById($request->validated());
            $assistanceResource = ['assistance' => new AssistanceResource($assistance)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($assistanceResource, 'buscar serviço');
    }

    public function update(AssistanceUpdateRequest $request): JsonResponse
    {
        $updatedResource = [];
        try {
            $updated = $this->assistanceService->update($request->validated());
            $updatedResource = ['assistance' => new AssistanceResource($updated)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($updatedResource, 'atualizar serviço');
    }

    public function destroy(AssistanceDestroyRequest $request): JsonResponse
    {
        try {
            $this->assistanceService->delete($request->validated());

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse([], 'excluir serviço');
    }
}