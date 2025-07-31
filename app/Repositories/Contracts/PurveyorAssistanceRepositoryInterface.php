<?php

namespace App\Repositories\Contracts;

use App\Models\PurveyorAssistance;

interface PurveyorAssistanceRepositoryInterface
{
    public function findByPurveyorAndAssistance(int $purveyorId, int $assistanceId): ?PurveyorAssistance;
}