<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\CheckAuthorized;
use App\Traits\HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ProjectController extends Controller
{

    use HttpResponse, CheckAuthorized;

    public function index()
    {
        return $this->success([
            "projects" => ProjectResource::collection(
                Project::where('user_id', auth()->user()->id)->get()
            )
        ], "Request success", 200);
    }
    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            return $this->IsNotAuthorized($project) ? $this->IsNotAuthorized($project) :  $this->success([
                "project" => new ProjectResource($project)
            ], "Project was found", 200);
        } catch (ModelNotFoundException $e) {
            return $this->error('Project Not Found', 404);
        }
    }
    public function store(StoreProjectRequest $request)
    {
        // Validate project
        $request->validated($request->all());

        // Store project
        $project = Project::create([
            "name" => $request->name,
            "description" => $request->description,
            "user_id" => auth()->user()->id,
        ]);

        return $this->success([
            "project" => new ProjectResource($project)
        ], "New project created successful", 201);
    }
    public function update(Request $request, Project $project)
    {
        if ($this->IsNotAuthorized($project)) {
            return $this->IsNotAuthorized($project);
        }
        $request->validate([
            "name" => [Rule::unique('projects', 'name')->ignore($project)]
        ]);
        $project->update($request->all());
        return $this->success(new ProjectResource($project), "Project updated successful", 200);
    }
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return $this->error('Project Not Found', 404);
        }
        if ($this->IsNotAuthorized($project)) {
            return $this->IsNotAuthorized($project);
        }
        $project->delete();
        return $this->success(null, 'Deleted successful', 204);
    }
}
