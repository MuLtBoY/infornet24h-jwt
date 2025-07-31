<?php

namespace App\Services\Purveyor;

use App\Models\Purveyor;
use App\Repositories\Contracts\PurveyorRepositoryInterface;

class PurveyorService
{
    protected $repository;

    public function __construct(protected PurveyorRepositoryInterface $purveyorRepository) {}

    public function getById(array $data): ?Purveyor
    {
        return $this->purveyorRepository->find($data['purveyor_id']);
    }

    public function create(array $data): Purveyor
    {
        return $this->purveyorRepository->create($data);
    }

    public function update(array $data): Purveyor
    {
        return $this->purveyorRepository->update($data['id'], $data);
    }

    public function delete(array $data): bool
    {
        return $this->purveyorRepository->delete($data['purveyor_id']);
    }
}