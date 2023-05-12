<?php

namespace App\Modules\Project\Model;

use App\Modules\CustomModel;
use App\Modules\User\Model\User;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
