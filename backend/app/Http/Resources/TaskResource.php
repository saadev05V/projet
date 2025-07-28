<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date ? $this->due_date->format('Y-m-d H:i:s') : null, // Handle null due_date
            'status' => $this->status,
            'project_id' => $this->project_id, // You might expose just the ID, or the full project resource
            'project' => new ProjectResource($this->whenLoaded('project')), // Optionally include full project
            'creator' => new UserResource($this->whenLoaded('user')), // The user who created this task
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}