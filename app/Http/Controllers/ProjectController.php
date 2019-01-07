<?php

namespace Server\Http\Controllers;

use Server\Project;
use Server\Developer;
use Server\Http\Resources\ProjectResource;
use Server\Http\Resources\ProjectsCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function __construct(Project $project)
    {
      $this->middleware('auth:api', ['except' => ['index', 'show'] ]);
    }

    public function index()
    {
      try {
        $projects = Project::all();
        return new ProjectsCollection($projects);
      } catch (\Exception $e) {
        Log::critical("Could not show projects: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["projects"=>"Something was wrong"], 500);
      }

    }


    public function store(Request $request)
    {
      try {
        if ($request->isMethod('PUT')) {
          $project = Project::findOrFail($request->id);
          $developer_user = Developer::where('user_id', $request->user()->id)->first();
          if ($project->developer == $developer_user) {
            $developer = $developer_user;
          }else{
            return Response()->json(["project"=>"You don't have permission to update this project"], 403 );
          }
        }else {
          $project = new Project;
          $developer = Developer::where('user_id', $request->user()->id)->first();
        }

        $title = $request->input('title');
        $description = $request->input('description');
        $website = $request->input('website');
        $country = $request->input('country');
        $published_at = $request->input('published_at');
        $technologies = $request->input('technologies');

        $project->title = $title ? $title : $project->title;
        $project->description = $description ? $description : $project->description;
        $project->website = $website ? $website : $project->website;
        $project->country = $country ? $country : $project->country;
        $project->published_at = $published_at ? $published_at : $project->published_at;

        if ($project->developer()->associate($developer) && $project->save()) {
          if ($technologies) {
            $skills = [];
            foreach ($technologies as $tech) {
              $skills[] = $tech['id'];
            }
            $project->skills()->sync($skills);
          }
          return new ProjectResource($project);
        }

      } catch (\Exception $e) {
        Log::critical("Could not create new project: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["project"=>"Something was wrong"], 500);
      }

    }


    public function show(Project $project)
    {
      try {
        $project = Project::findOrFail($project->id);
        return new ProjectResource($project);
      } catch (\Exception $e) {
        Log::critical("Could not show specific project: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["project"=>"Something was wrong"], 500);
      }
    }


    // $developer_id  del proyecto = developer_id del usuario
    public function destroy(Request $request, Project $project)
    {
      try {
        $developer_user = Developer::where('user_id', $request->user()->id)->first();
        if ($project->developer == $developer_user) {
          $project->delete();
          return new ProjectResource($project);
        }
        return Response()->json(["project"=>"You don't have permission to delete this project"], 403);
      } catch (\Exception $e) {
        Log::critical("Could not delete project: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["project"=>"Something was wrong"], 500);
      }
    }
}
