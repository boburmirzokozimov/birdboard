<?php

namespace Tests\Unit;

use App\Modules\Project\Model\Project;
use App\Modules\User\Model\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_a_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    public function test_belongs_to_an_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    public function test_can_add_a_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask(['body' => 'Test Task']);

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_can_have_many_tasks()
    {
        $project = Project::factory()->create();

        $task = $project->tasks;

        $this->assertInstanceOf(Collection::class, $task);
    }
}
