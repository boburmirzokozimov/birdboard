<?php

namespace Tests\Feature;

use App\Modules\Project\Model\Project;
use App\Modules\Project\Model\Task\Task;
use Facades\Tests\Setup\ProjectFactory;
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

    public function test_a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();


        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'New Changed Body',
            ]);

        $this->assertDatabaseHas('projects_tasks', [
            'body' => 'New Changed Body',
        ]);
    }

    public function test_a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();


        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'New Changed Body',
                'completed' => true
            ]);

        $this->assertDatabaseHas('projects_tasks', [
            'body' => 'New Changed Body',
            'completed' => true
        ]);
    }

    public function test_a_task_can_be_marked_incomplete()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'New Changed Body',
                'completed' => true
            ]);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'New Changed Body',
            'completed' => false
        ]);


        $this->assertDatabaseHas('projects_tasks', [
            'body' => 'New Changed Body',
            'completed' => false
        ]);
    }


    public function test_a_task_requires_a_body()
    {
        $this->signIn();

        $task = Task::factory()->create(['body' => '']);

        $this->post($task->project->path() . '/task')->assertSessionMissing('body');
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

        $project = ProjectFactory::ownedBy()
            ->withTasks(1)
            ->create();

        $this->post($project->path() . '/task', $project->tasks->first()->toArray())
            ->assertStatus(403);

        $this->assertDatabaseHas('projects_tasks', $project->tasks->first()->toArray());
    }

    public function test_only_the_owner_of_project_can_update_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::ownedBy()
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'New'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('projects_tasks', ['body' => 'New']);
    }
}
