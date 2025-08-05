<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User; // Import User model
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource; // Import ProjectResource
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Validation\ValidationException; // For custom validation errors

class ProjectController extends Controller
{
    /**
     * Display a listing of projects accessible to the authenticated user.
     * Includes projects created by the user AND projects the user is a member of.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = Auth::user();

        // Get projects created by the user
        $createdProjects = $user->projects()->with('user', 'members')->get();

        // Get projects where the user is a member (excluding those already created by the user)
        $memberOfProjects = $user->memberOfProjects()->where('projects.user_id', '!=', $user->id)->with('user', 'members')->get();

        // Combine and ensure unique projects
        $projects = $createdProjects->merge($memberOfProjects)->unique('id')->sortByDesc('created_at');

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'member_ids' => ['array'], // Array of user IDs to add as members
            'member_ids.*' => ['exists:users,id'], // Each ID must exist in the users table
        ]);

        $user = Auth::user();

        $project = $user->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Attach creator as a member automatically if not already included
        if (!$project->members->contains($user->id)) {
            $project->members()->attach($user->id);
        }

        // Attach additional members if provided
        if ($request->has('member_ids')) {
            // Filter out the creator's ID if it's in the member_ids list to avoid duplicate attachment
            $newMembers = collect($request->member_ids)->filter(function ($memberId) use ($user) {
                return $memberId != $user->id;
            });

            // Attach new members without detaching existing ones
            $project->members()->syncWithoutDetaching($newMembers);
        }

        return new ProjectResource($project->load('user', 'members')); // Eager load user and members for response
    }

    /**
     * Display the specified project.
     *
     * @param  \App\Models\Project  $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(Project $project)
    {
        // Authorization: Check if the authenticated user is the creator or a member of the project
        if (!$this->isProjectCreatorOrMember($project)) {
            abort(403, 'Unauthorized. You are not a member of this project.');
        }

        return new ProjectResource($project->load('user', 'tasks', 'members'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function update(Request $request, Project $project)
    {
        // Authorization: Only the project creator can update
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. Only the project creator can update this project.');
        }

        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'member_ids' => ['array'], // Array of user IDs to set as members
            'member_ids.*' => ['exists:users,id'],
        ]);

        $project->update($request->only('name', 'description'));

        // Sync members: this will detach any existing members not in the new list
        // and attach any new members.
        // Ensure the creator is always kept as a member unless explicitly removed (which we'll prevent for simplicity)
        $membersToSync = collect($request->member_ids)->push(Auth::id())->unique()->toArray();
        $project->members()->sync($membersToSync);


        return new ProjectResource($project->load('user', 'members'));
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        // Authorization: Only the project creator can delete
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. Only the project creator can delete this project.');
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
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
