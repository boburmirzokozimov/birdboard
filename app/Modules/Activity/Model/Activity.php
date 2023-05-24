<?php

namespace App\Modules\Activity\Model;

use App\Modules\CustomModel;
use App\Modules\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends CustomModel
{
    use HasFactory;

    protected $casts = [
        'changes' => 'array'
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
