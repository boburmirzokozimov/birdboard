<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateRequest;
use App\Modules\Project\Model\Project;
use App\Modules\Project\Model\ProjectRepository;

class ProjectController extends Controller
{
    public function __construct(private ProjectRepository $repository)
    {
    }

    public function index()
    {
        return view('projects.index', [
            'projects' => auth()->user()->projects
        ]);
    }

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function store(CreateRequest $request)
    {
        $project = auth()->user()->projects()->create($request->validated());

        return redirect('/projects');
    }

    public function create()
    {
        return view('projects.create');
    }
}
