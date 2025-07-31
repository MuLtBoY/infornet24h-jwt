<?php

namespace App\Http\Controllers;

use App\Http\Requests\Geocode\GeocodeByAddressRequest;
use App\Http\Resources\GeocodeResource;
use App\Services\GeocodeRouteService;
use Illuminate\Http\JsonResponse;
use Throwable;

class GeocodeController extends Controller
{
    public function __construct(protected GeocodeRouteService $geocodeRouteService) {}

    public function geocodeByAddress(GeocodeByAddressRequest $request): JsonResponse
    {
        $geocodeResource = [];
        try {
            $geocode = $this->geocodeRouteService->getGeo($request->validated());
            $geocodeResource = ['geocode' => new GeocodeResource($geocode)];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($geocodeResource, 'buscar latitude e longitude');
    }
}
