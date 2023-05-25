<?php

namespace App\Modules\User\Model;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\Project\Model\Project;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    public function accessibleProjects()
    {
        return Project::query()->where('owner_id', $this->id)
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->get();
//        $projectsCreated = $this->projects;
//
//        $ids = DB::table('project_members')->where('user_id', $this->id)->pluck('project_id');
//
//        $sharedProjects = Project::find($ids);
//
//        return $projectsCreated->merge($sharedProjects);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id')->latest('updated_at');
    }
}
