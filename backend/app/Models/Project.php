<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'user_id', // Make sure 'user_id' is fillable as it's set on creation
    ];

    // --- Relationships ---

    /**
     * A project belongs to a user (the creator).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A project has many tasks.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * A project has many members (users).
     * This uses the 'project_user' pivot table.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}