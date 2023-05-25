<?php

namespace Tests\Feature;

use App\Http\Controllers\Project\ProjectTaskController;
use App\Modules\User\Model\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $userInviteTo = User::factory()->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'id' => $userInviteTo->id
            ]);

        $this->assertTrue($project->members->contains($userInviteTo));
    }

    public function test_a_project_can_remove_a_user()
    {
        $project = ProjectFactory::create();

        $userInviteTo = User::factory()->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'id' => $userInviteTo->id
            ]);

        $this->assertTrue($project->members->contains($userInviteTo));

        $this->actingAs($project->owner)
            ->delete($project->path() . '/invitations', [
                'id' => $userInviteTo->id
            ]);

        $project->refresh();
        
        $this->assertFalse($project->members->contains($userInviteTo));

    }

    public function test_invited_users_may_update_project(): void
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = User::factory()->create());

        $this->actingAs($newUser)
            ->post(action([ProjectTaskController::class, 'store'], $project), $task = ['body' => 'New Task Added']);

        $this->assertDatabaseHas('projects_tasks', $task);
    }

    public function test_non_owners_may_not_add_a_user()
    {
        $project = ProjectFactory::create();

        $this->actingAs($this->signIn())
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    }
}
