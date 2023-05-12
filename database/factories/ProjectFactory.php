<?php

namespace Database\Factories;

use App\Modules\Project\Model\Project;
use App\Modules\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'owner_id' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}
