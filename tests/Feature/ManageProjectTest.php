<?php

namespace Tests\Feature;

use App\Modules\Project\Model\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_create_a_project()
    {
        $attributes = Project::factory()->raw();

        $this->post('/projects', $attributes)->assertRedirect('/login');
    }

    public function test_guests_cannot_view_projects()
    {
        $this->get('/projects')->assertRedirect('/login');
    }

    public function test_guests_cannot_view_a_single_project()
    {
        $project = Project::factory()->create();

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

    public function test_a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 150));
    }

    public function test_a_user_cannot_view_others_projects()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertForbidden();
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
