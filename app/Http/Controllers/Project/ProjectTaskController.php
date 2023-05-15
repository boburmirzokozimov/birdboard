<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\Task\CreateRequest;
use App\Modules\Project\Model\Project;

class ProjectTaskController extends Controller
{
    public function store(Project $project, CreateRequest $request)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        $project->addTask($request->validated());

        return redirect($project->path());
    }
}
