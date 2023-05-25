<?php

namespace Tests\Unit;

use App\Modules\User\Model\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_projects(): void
    {
        $user = User::factory()->make();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_has_accessible_projects()
    {
        $bob = $this->signIn();

        ProjectFactory::ownedBy($bob)->create();

        $this->assertCount(1, $bob->accessibleProjects());

        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $project = tap(ProjectFactory::ownedBy($sally)->create())->invite($nick);

        $this->assertCount(1, $bob->accessibleProjects());

        $project->invite($bob);

        $this->assertCount(2, $bob->accessibleProjects());
    }
}
