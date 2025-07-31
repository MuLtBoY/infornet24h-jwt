<?php

namespace App\Repositories;

use App\Models\PurveyorAssistance;
use App\Repositories\Contracts\PurveyorAssistanceRepositoryInterface;

class EloquentPurveyorAssistanceRepository implements PurveyorAssistanceRepositoryInterface
{
    public function findByPurveyorAndAssistance(int $purveyorId, int $assistanceId): ?PurveyorAssistance
    {
        return PurveyorAssistance::where('purveyor_id', $purveyorId)
            ->where('assistance_id', $assistanceId)
            ->first();
    }
}