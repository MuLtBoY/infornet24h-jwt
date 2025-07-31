<?php

namespace App\Services\Infornet;

class StatusPurveyorService extends BaseInfornetService
{
    public function getStatus(array $purveyors)
    {
        return $this->client()->post('prestadores/online', [
            'prestadores' => $purveyors,
        ]);
    }
}