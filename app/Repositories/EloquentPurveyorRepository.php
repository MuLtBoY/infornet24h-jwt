<?php

namespace App\Repositories;

use App\Models\Purveyor;
use App\Repositories\Contracts\PurveyorRepositoryInterface;

class EloquentPurveyorRepository implements PurveyorRepositoryInterface
{
    public function find($id): ?Purveyor
    {
        return Purveyor::findOrFail($id);
    }

    public function create(array $data): Purveyor
    {
        return Purveyor::create($data);
    }

    public function update($id, array $data): Purveyor
    {
        $purveyor = $this->find($id);
        $purveyor->update($data);
        return $purveyor;
    }

    public function delete($id): bool
    {
        $purveyor = $this->find($id);
        return $purveyor->delete();
    }
}