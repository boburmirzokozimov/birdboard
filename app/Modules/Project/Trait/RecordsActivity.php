<?php

namespace App\Modules\Project\Trait;

use App\Modules\Activity\Model\Activity;
use App\Modules\Project\Model\Project;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    public array $oldAttributes = [];

    public static function bootRecordsActivity(): void
    {
        static::updating(function ($model) {
            $model->oldAttributes = $model->getOriginal();
        });

        if (isset(static::$recordableEvents)) {
            $recordableEvents = static::$recordableEvents;
        } else {
            $recordableEvents = ['created', 'updated'];
        }

        foreach ($recordableEvents as $event) {
            static::$event(function ($model) use ($event) {
                if (class_basename($model) !== 'Project') {
                    $event = "{$event}_" . strtolower(class_basename($model));
                }
                $model->recordActivity($event);
            });
        }
    }

    public function recordActivity(string $description): Activity
    {
        return $this->activity()->create([
            'description' => $description,
            'user_id' => ($this->project ?? $this)->owner->id,
            'changes' => [
                'before' => array_diff($this->oldAttributes, $this->getAttributes()),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ],
            'project_id' => class_basename($this) === Project::class ? $this->id : $this->project_id
        ]);
    }

    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
