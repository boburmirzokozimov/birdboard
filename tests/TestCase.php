<?php

namespace Tests;

use App\Modules\User\Model\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn(User $user = null): void
    {
        $this->actingAs($user ?: User::factory()->create());
    }
}
