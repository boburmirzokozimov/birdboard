<?php

namespace Tests\Setup;

use App\Modules\Project\Model\Project;
use App\Modules\Project\Model\Task\Task;
use App\Modules\User\Model\User;

class ProjectFactory
{
    protected ?int $tasksCount = null;
    protected ?User $user;


    public function withTasks(int $count = 0): self
    {
        $this->tasksCount = $count;
        return $this;
    }

    public function ownedBy(User $user = null): self
    {
        $this->user = $user;
        return $this;
    }

    public function create(): Project
    {
        $project = Project::factory()->create([
                'owner_id' => $this->user ?? User::factory()
            ]
        );

        if ($this->tasksCount) {
            Task::factory(count: $this->tasksCount)->create([
                'project_id' => $project->id
            ]);
        }

        return $project;
    }
}
