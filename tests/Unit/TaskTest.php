<?php

namespace Tests\Unit;

use App\Modules\Project\Model\Project;
use App\Modules\Project\Model\Task\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    public function test_it_has_a_path(): void
    {
        $task = Task::factory()->create();

        $this->assertEquals('/projects/' . $task->project->id . '/task/' . $task->id, $task->path());
    }

    public function test_it_can_be_completed()
    {
        $task = Task::factory()->create();

        $this->assertFalse($task->fresh()->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

    public function test_it_can_be_marked_incomplete()
    {
        $task = Task::factory()->create(['completed' => true]);

        $this->assertTrue($task->fresh()->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
