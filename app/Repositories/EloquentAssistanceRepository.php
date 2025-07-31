<?php

namespace App\Repositories;

use App\Models\Assistance;
use App\Repositories\Contracts\AssistanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentAssistanceRepository implements AssistanceRepositoryInterface
{
    public function all(): ?Collection
    {
        return Assistance::all();
    }

    public function find($id): ?Assistance
    {
        return Assistance::findOrFail($id);
    }

    public function create(array $data): Assistance
    {
        return Assistance::create($data);
    }

    public function update($id, array $data): Assistance
    {
        $assistance = $this->find($id);
        $assistance->update($data);
        return $assistance;
    }

    public function delete($id): bool
    {
        $assistance = $this->find($id);
        return $assistance->delete();
    }
}