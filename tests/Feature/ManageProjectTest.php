<?php

namespace Tests\Feature;

use App\Modules\Project\Model\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();

        $this->post('/projects', $project->toArray())->assertRedirect('/login');
        $this->get('/projects')->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
        $this->patch($project->path())->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
    }

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $project = Project::factory()->raw();

        $this->post('/projects', $project)->assertRedirect('/projects');
    }

    public function test_the_owner_can_update_the_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), [
                'notes' => 'New Updated Notes',
                'title' => 'Changed',
                'description' => 'Changed',
            ]);

        $this->get($project->path())
            ->assertSee(['New Updated Notes']);

        $this->assertDatabaseHas('projects', [
            'notes' => 'New Updated Notes',
            'title' => 'Changed',
            'description' => 'Changed',
        ]);
    }

    public function test_the_owner_can_delete_the_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    public function test_unauthorized_users_cannot_delete_the_project()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())
            ->assertStatus(403);
    }

    public function test_a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 150))
            ->assertSee($project->notes);
    }

    public function test_a_user_cannot_view_others_projects()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertForbidden();
    }


    public function test_a_user_cannot_update_others_projects()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path())->assertForbidden();
    }


    public function test_a_project_requires_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
