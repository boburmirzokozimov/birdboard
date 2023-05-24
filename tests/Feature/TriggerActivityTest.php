<?php

namespace Tests\Feature;

use App\Modules\Project\Model\Task\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    function test_creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        $this->assertEquals('created', $project->activity[0]->description);
    }

    function test_updating_a_project()
    {
        $project = ProjectFactory::create();
        $originalTitle = $project->title;


        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated', $activity->description);

            $expected = [
                'before' => [
                    'title' => $originalTitle,
                ],
                'after' => [
                    'title' => 'Changed',
                ]
            ];

            $this->assertEquals($expected, $activity->changes);

        });
    }

    function test_creating_a_task_for_a_project()
    {
        $project = ProjectFactory::create();

        $project->addTask(['body' => 'New Task']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    function test_deleting_a_task_for_a_project()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks->first();

        $this->actingAs($project->owner)
            ->delete($project->path() . '/task', ['id' => $task->id]);

        $this->assertCount(3, $project->refresh()->activity);

        $this->assertEquals('deleted_task', $project->refresh()->activity->last()->description);
    }

    function test_completing_a_task_for_a_project()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks->first();

        $this->actingAs($project->owner)
            ->patch($task->path(), [
                'body' => 'New Changed Name',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->assertEquals('completed_task', $project->activity->last()->description);
    }


    function test_incomplete_a_task_for_a_project()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks->first();

        $this->actingAs($project->owner)
            ->patch($task->path(), [
                'body' => 'New Changed Name',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->patch($task->path(), [
            'body' => 'New Changed Incomplete',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        $this->assertEquals('incomplete_task', $project->activity->last()->description);
    }


}
