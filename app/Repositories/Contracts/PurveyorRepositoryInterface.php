<?php

namespace App\Repositories\Contracts;

use App\Models\Purveyor;

interface PurveyorRepositoryInterface
{
    public function create(array $data): Purveyor;

    public function find(int $id): ?Purveyor;

    public function update(int $id, array $data): Purveyor;

    public function delete(int $id): bool;
}