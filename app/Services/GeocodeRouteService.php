<?php

namespace App\Services;

use App\Services\Infornet\GeocodeService;

class GeocodeRouteService
{
    public function __construct(protected GeocodeService $geocodeService) {}

    public function getGeo(array $data): array
    {
        $geo = $this->geocodeService->getGeocode($data['address']);
        if ($geo->failed()) {
            throw new \RuntimeException("Falha ao obter coordenadas de: {$data['address']}");
        }

        return $geo->json();
    }
}