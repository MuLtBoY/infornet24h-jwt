<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeocodeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'address' => $this['display_name'],
            'latitude' => $this['lat'],
            'longitude' => $this['lon'],
        ];
    }
}