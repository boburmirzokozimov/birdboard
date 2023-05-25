<?php

namespace App\Modules\Project\Policies;


use App\Modules\Project\Model\Project;
use App\Modules\User\Model\User;

class ProjectPolicy
{
    public function update(User $user, Project $project)
    {
        return $user->is($project->owner) || $project->members->contains($user);
    }
}
