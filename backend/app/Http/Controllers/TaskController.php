<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks for a specific project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Project $project)
    {
        // Authorization: Check if the authenticated user is the creator or a member of the project
        if (!$this->isProjectCreatorOrMember($project)) {
            abort(403, 'Unauthorized. You are not a member of this project.');
        }

        $tasks = $project->tasks()->with('user', 'project')->get();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \App\Http\Resources\TaskResource
     */
    public function store(Request $request, Project $project)
    {
        // Authorization: Check if the authenticated user is the creator or a member of the project
        if (!$this->isProjectCreatorOrMember($project)) {
            abort(403, 'Unauthorized. You are not a member of this project.');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'status' => ['sometimes', 'string', 'in:pending,in progress,completed,overdue'],
        ]);

        $task = $project->tasks()->create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status ?? 'pending',
        ]);

        return new TaskResource($task->load('user', 'project'));
    }

    /**
     * Display the specified task.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \App\Http\Resources\TaskResource
     */
    public function show(Project $project, Task $task)
    {
        // Authorization: Check if the task belongs to the project and user has access
        if ($task->project_id !== $project->id) {
            abort(404, 'Task not found in this project.');
        }

        if (!$this->isProjectCreatorOrMember($project)) {
            abort(403, 'Unauthorized. You are not a member of this project.');
        }

        return new TaskResource($task->load('user', 'project'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \App\Http\Resources\TaskResource
     */
    public function update(Request $request, Project $project, Task $task)
    {
        // Authorization: Check if the task belongs to the project and user has access
        if ($task->project_id !== $project->id) {
            abort(404, 'Task not found in this project.');
        }

        if (!$this->isProjectCreatorOrMember($project)) {
            abort(403, 'Unauthorized. You are not a member of this project.');
        }

        $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'status' => ['sometimes', 'string', 'in:pending,in progress,completed,overdue'],
        ]);

        $task->update($request->only(['title', 'description', 'due_date', 'status']));

        return new TaskResource($task->load('user', 'project'));
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project, Task $task)
    {
        // Authorization: Check if the task belongs to the project and user has access
        if ($task->project_id !== $project->id) {
            abort(404, 'Task not found in this project.');
        }

        if (!$this->isProjectCreatorOrMember($project)) {
            abort(403, 'Unauthorized. You are not a member of this project.');
        }

        // Optional: Only allow task creator or project creator to delete
        if ($task->user_id !== Auth::id() && $project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. Only the task creator or project creator can delete this task.');
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }

    /**
     * Helper method for project access authorization.
     *
     * @param  \App\Models\Project  $project
     * @return bool
     */
    protected function isProjectCreatorOrMember(Project $project): bool
    {
        $user = Auth::user();
        return $project->user_id === $user->id || $project->members->contains($user->id);
    }
}
