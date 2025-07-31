<?php

namespace App\Http\Resources;

class PurveyorWithMetricsResource extends PurveyorResource
{
    public function toArray($request): array
    {
        $data = parent::toArray($request);

        if (isset($this->resource->status)) {
            $data['status'] = $this->status;
        }

        if (isset($this->resource->distance)) {
            $data['distance'] = $this->distance;
        }

        if (isset($this->resource->value)) {
            $data['value'] = $this->value;
        }

        return $data;
    }
}