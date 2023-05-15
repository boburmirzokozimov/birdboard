<?php

namespace App\Modules\Project\Model;

use App\Modules\CustomModel;
use App\Modules\Project\Model\Task\Task;
use App\Modules\User\Model\User;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends CustomModel
{
    protected static function newFactory(): ProjectFactory
    {
        return new ProjectFactory();
    }

    public function path(): string
    {
        return "/projects/$this->id";
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addTask(array $validated)
    {
        return $this->tasks()->create($validated);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class,);
    }

}
