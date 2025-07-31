<?php

namespace App\Repositories\Contracts;

use App\Models\Assistance;
use Illuminate\Database\Eloquent\Collection;

interface AssistanceRepositoryInterface
{
    public function all(): ?Collection;

    public function create(array $data): Assistance;

    public function find(int $id): ?Assistance;

    public function update(int $id, array $data): Assistance;

    public function delete(int $id): bool;
}