<?php

declare(strict_types=1);

namespace App\Modules\Project\Model;

use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
    public function getAll(): Collection
    {
        return Project::all();
    }

    public function create(array $values): void
    {
        Project::query()->create($values);
    }
}
