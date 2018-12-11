<?php

namespace Server\Http\Controllers;

use Server\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
      if ($request->isMethod('PUT')) {
        $project = Project::findOrFail($request->id);
      }else {
        $project = new Project;
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

      $project->save();

      if ($technologies) {
        $skills = [];
        foreach ($technologies as $tech) {
          $skills[] = $tech['id'];
        }
        $project->skills()->sync($skills);
      }

      return $project;

    }


    public function show(Project $project)
    {
        $project = Project::findOrFail($project);
        return $project;
    }


    public function destroy(Project $project)
    {
      $project->delete();
      return $project;
    }
}
