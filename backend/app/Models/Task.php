<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'due_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
    ];

    // --- Relationships ---

    /**
     * A task belongs to a project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * A task belongs to a user (the creator/owner).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}