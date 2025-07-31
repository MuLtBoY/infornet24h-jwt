<?php

namespace App\Services;

use App\Models\Assistance;
use App\Repositories\Contracts\AssistanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AssistanceService
{
    protected $repository;

    public function __construct(protected AssistanceRepositoryInterface $assistanceRepository) {}

    public function getAll(): ?Collection
    {
        return $this->assistanceRepository->all();
    }

    public function getById(array $data): ?Assistance
    {
        return $this->assistanceRepository->find($data['assistance_id']);
    }

    public function create(array $data): Assistance
    {
        return $this->assistanceRepository->create($data);
    }

    public function update(array $data): Assistance
    {
        return $this->assistanceRepository->update($data['id'], $data);
    }

    public function delete(array $data): bool
    {
        return $this->assistanceRepository->delete($data['assistance_id']);
    }
}