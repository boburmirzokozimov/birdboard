<?php

namespace Tests\Unit;

use App\Modules\User\Model\User;
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
}
