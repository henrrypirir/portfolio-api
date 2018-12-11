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
      $title = $request->input('title');
      $description = $request->input('description');
      $website = $request->input('website');
      $country = $request->input('country');
      $published_at = $request->input('published_at');
      $technologies = $request->input('technologies');

      $project = new Project;
      $project->title = $title;
      $project->description = $description;
      $project->website = $website;
      $project->country = $country;
      $project->published_at = $published_at;

      $project->save();

      if ($technologies) {
        $skills = [];
        foreach ($technologies as $tech) {
          $skills = $tech['id'];
        }
        $project->skills()->sync($skills);
      }
      
    }


    public function show(Project $project)
    {
        //
    }


    public function destroy(Project $project)
    {
        //
    }
}
