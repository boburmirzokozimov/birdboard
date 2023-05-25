<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Modules\Project\Model\Project;
use App\Modules\User\Model\User;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => auth()->user()->accessibleProjects(),
        ]);
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', [
            'project' => $project,
            'users' => User::all()
        ]);
    }

    public function store(CreateRequest $request)
    {
        auth()->user()->projects()->create($request->validated());

        return redirect('/projects');
    }

    public function create()
    {
        return view('projects.create');
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    public function update(UpdateRequest $request, Project $project)
    {
        return redirect($request->persist()->path());
    }
}
