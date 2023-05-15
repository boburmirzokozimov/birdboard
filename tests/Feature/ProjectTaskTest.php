<?php

namespace Tests\Feature;

use App\Modules\Project\Model\Project;
use App\Modules\Project\Model\Task\Task;
use App\Modules\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks()
    {

        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);


        $this->post($project->path() . '/task', ['body' => 'Test Task'])
            ->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee('Test Task');
    }

    public function test_can_see_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }


    public function test_a_task_requires_a_body()
    {
        $this->signIn();

        $task = Task::factory()->create(['body' => '']);

        $this->post($task->project->path() . '/task')->assertSessionHasErrors('body');
    }

    public function test_guests_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/task', $project->toArray())
            ->assertRedirect('login');
    }

    public function test_only_the_owner_of_project_can_add_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => User::factory()->create()->id]);

        $task = Task::factory()->raw(['project_id' => $project->id]);

        $this->post($project->path() . '/task', $task)
            ->assertStatus(403);

        $this->assertDatabaseMissing('projects_tasks', $task);
    }
}
