<?php

namespace App\Services\Purveyor;

use App\Models\Purveyor;
use App\Repositories\Contracts\PurveyorAssistanceRepositoryInterface;
use App\Services\Infornet\GeocodeService;
use App\Services\Infornet\StatusPurveyorService;
use Illuminate\Support\Collection;

class PurveyorSearchService
{
    public function __construct(
        protected StatusPurveyorService $statusService,
        protected GeocodeService $geocodeService,
        protected PurveyorAssistanceRepositoryInterface $purveyorAssistanceRepository
    ) {
        $this->statusService = $statusService;
        $this->geocodeService = $geocodeService;
    }

    public function handle(array $data): Collection
    {
        $quantity = $data['quantity'] ?? 100;
        $query = $this->applyFilters(Purveyor::query(), $data['filters']);

        $query = $this->applyQuerySorting($query, $data['sort'] ?? []);

        $purveyors = $query->limit($quantity)->get();

        $purveyors = $this->applyInMemorySorting($purveyors, $data);
        if (!empty($data['filters']['provider_status'])) {
            $purveyors = $purveyors->filter(
                fn($purveyor) => $purveyor->status === $data['filters']['provider_status']
            );
        }

        return $purveyors->take($quantity)->values();
    }

    protected function applyFilters($query, array $filters)
    {
        return $query
            ->when(!empty($filters['city']), fn($q) => $q->where('city', $filters['city']))
            ->when(!empty($filters['uf']), fn($q) => $q->where('uf', $filters['uf']));
    }

    protected function applyQuerySorting($query, array $sort)
    {
        return $query
            ->when(in_array('value', $sort), fn($q) => $q->orderBy('value'))
            ->when(in_array('city', $sort), fn($q) => $q->orderBy('city'))
            ->when(in_array('uf', $sort), fn($q) => $q->orderBy('uf'));
    }

    protected function applyInMemorySorting(Collection $purveyors, array $data): Collection
    {
        $sort = $data['sort'] ?? [];

        $purveyors = $this->attachStatuses($purveyors);
        if (in_array('provider_status', $sort)) {
            $purveyors->sortBy('status');
        }

        $assistanceId = $data['assistance_id'];
        $purveyors = $purveyors->map(function ($purveyor) use ($data, $assistanceId) {
            $distance1 = $this->haversineDistance($purveyor->latitude, $purveyor->longitude, $data['origin_latitude'], $data['origin_longitude']);
            $distance2 = $this->haversineDistance($data['origin_latitude'], $data['origin_longitude'], $data['destiny_latitude'], $data['origin_longitude']);
            $distance3 = $this->haversineDistance($data['destiny_latitude'], $data['destiny_longitude'], $purveyor->latitude, $purveyor->longitude);

            $totalKm = ($distance1 + $distance2 + $distance3) / 1000; //convert metters to km

            $purveyor->distance = round($totalKm, 1);

            $purveyorAssistance = $this->purveyorAssistanceRepository->findByPurveyorAndAssistance($purveyor->id, $assistanceId);

            if (!$purveyorAssistance) {
                $purveyor->value = null;
                return $purveyor;
            }

            $excessKm = max(0, $totalKm - $purveyorAssistance->start_km);
            $purveyor->value = round($purveyorAssistance->start_value + ($excessKm * $purveyorAssistance->value_km), 2);

            return $purveyor;
        })->filter(fn($purveyor) => $purveyor->value !== null);

        if (in_array('value', $sort)) {
            $purveyors->sortBy('value');
        }

        if (in_array('distance', $sort)) {
            $purveyors->sortBy('distance');
        }

        return $purveyors->values();
    }

    protected function attachStatuses(Collection $purveyors): Collection
    {
        $ids = $purveyors->pluck('id')->toArray();

        if(!count($ids)){
            return $purveyors;
        }

        $response = $this->statusService->getStatus($ids);
        if ($response->failed()) {
            throw new \RuntimeException('Falha ao buscar status dos prestadores.');
        }

        $statuses = collect($response->json()['prestadores']);

        return $purveyors->map(function ($purveyor) use ($statuses) {
            $purveyor->status = strtolower($statuses->firstWhere('idPrestador', $purveyor->id)['status']) ?? 'offline';
            return $purveyor;
        });
    }

    protected function getGeo(string $address): array
    {
        $geo = $this->geocodeService->getGeocode($address);
        if ($geo->failed()) {
            throw new \RuntimeException("Falha ao obter coordenadas de: {$address}");
        }

        return $geo->json();
    }

    protected function haversineDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2,
        float $earthRadius = 6371000
    ): float {
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) ** 2 +
             cos($lat1) * cos($lat2) *
             sin($deltaLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}