<?php

namespace App\Services\Infornet;

class GeocodeService extends BaseInfornetService
{
    public function getGeocode(string $address)
    {
        return $this->client()->get("endereco/geocode/{$address}");
    }
}