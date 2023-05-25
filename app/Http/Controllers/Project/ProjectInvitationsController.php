<?php

declare(strict_types=1);

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\DeleteMemberRequest;
use App\Http\Requests\Project\InviteRequest;
use App\Modules\Project\Model\Project;

class ProjectInvitationsController extends Controller
{
    public function store(InviteRequest $request, Project $project)
    {
        return redirect($request->persist()->path());
    }

    public function destroy(DeleteMemberRequest $request, Project $project)
    {
        return redirect($request->remove()->path());
    }
}
