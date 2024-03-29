<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_MANAGER = 2;
    const ROLE_EXECUTOR = 3;

    protected $table = 'user';
    protected $plural = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
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
        'password' => 'hashed',
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'projects_users')->withPivot('role_id');
    }
    public function owned_tasks()
    {
        return $this->hasMany(Task::class, "creator_id", "id");
    }
    public function assigned_tasks()
    {
        return $this->hasMany(Task::class, "executor_id", "id");
    }
    public function tasks()
    {
        $ownedTasks = $this->owned_tasks;
        $assignedTasks = $this->assigned_tasks;
        return $ownedTasks->merge($assignedTasks);
    }
}
