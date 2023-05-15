<?php

namespace App\Modules\Project\Model\Task;

use App\Modules\CustomModel;
use App\Modules\Project\Model\Project;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends CustomModel
{
    use HasFactory;

    protected $table = 'projects_tasks';

    protected static function newFactory(): TaskFactory
    {
        return new TaskFactory();
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
