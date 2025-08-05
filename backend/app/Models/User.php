<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Project; // <--- IMPORTANT: Ensure this use statement is here
use App\Models\Task;    // <--- IMPORTANT: Ensure this use statement is here

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
        'password' => 'hashed',
    ];

    // --- Start of Eloquent Relationships ---

    /**
     * A user can create many projects.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * A user can create many tasks.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * A user can belong to many projects (as a member).
     * This uses the 'project_user' pivot table.
     */
    public function memberOfProjects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }

    // --- End of Eloquent Relationships ---
}