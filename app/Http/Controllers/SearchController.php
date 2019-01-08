<?php

namespace Server\Http\Controllers;

use Server\User;
use Server\Project;
use Server\Http\Resources\ProjectsCollection;
use Server\Http\Resources\DeveloperResource;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function filters(Request $request)
  {
    $developer = $request->get('developer');
    $projects = Project::all();

    if ($developer) {
      $user = User::where('name', $developer)->first();
      $projects = $projects->where('developer_id', $user->developer->id);
    }

    return new ProjectsCollection($projects);
  }
}
