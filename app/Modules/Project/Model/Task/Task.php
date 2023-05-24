<?php

namespace App\Modules\Project\Model\Task;

use App\Modules\CustomModel;
use App\Modules\Project\Model\Project;
use App\Modules\Project\Trait\RecordsActivity;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends CustomModel
{
    use HasFactory, RecordsActivity;

    protected static array $recordableEvents = ['created', 'deleted'];

    protected $table = 'projects_tasks';
    protected $touches = ['project'];
    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function newFactory(): TaskFactory
    {
        return new TaskFactory();
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function path(): string
    {
        return '/projects/' . $this->project->id . '/task/' . $this->id;
    }

    public function complete(): void
    {
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }

    public function incomplete(): void
    {
        $this->update(['completed' => false]);
        $this->recordActivity('incomplete_task');

    }

}
