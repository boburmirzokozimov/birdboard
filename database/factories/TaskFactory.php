<?php

namespace Database\Factories;

use App\Modules\Project\Model\Project;
use App\Modules\Project\Model\Task\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph(),
            'project_id' => Project::factory()
        ];
    }
}
