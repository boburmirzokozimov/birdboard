<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\Task\CreateRequest;
use App\Http\Requests\Project\Task\DeleteRequest;
use App\Http\Requests\Project\Task\UpdateRequest;
use App\Modules\Project\Model\Project;
use App\Modules\Project\Model\Task\Task;

class ProjectTaskController extends Controller
{
    public function store(Project $project, CreateRequest $request)
    {
        return redirect($request->persist()->path());
    }

    public function destroy(Project $project, DeleteRequest $request)
    {
        Task::destroy($request->validated());

        return redirect($project->path());
    }

    public function update(Project $project, Task $task, UpdateRequest $request)
    {
        $this->authorize('update', $project);

        $task->update([
            'body' => $request->validated()['body'],
        ]);

        if ($request->validated('completed')) {
            $task->complete();
        } else {
            $task->incomplete();
        }

        $task->save();

        return redirect($project->path());
    }
}
