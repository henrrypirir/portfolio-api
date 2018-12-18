<?php

namespace Server\Http\Controllers;

use Server\Skill;
use Server\Http\Resources\SkillResource;
use Server\Http\Resources\SkillsCollection;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function index()
    {
      $skills = Skill::all();
      return new SkillsCollection($skills);
    }

    public function store(Request $request)
    {
        //validar con token
        if ($request->isMethod('PUT')) {
          $skill = Skill::findOrFail($request->id);
        }else{
          $skill = new Skill;
        }

        $name = $request->input('name');

        $skill->name = $name ? $name : $skill->name;
        $skill->save();
        return new SkillResource($skill);
    }

    public function show(Skill $skill)
    {
      $skill = Skill::findOrFail($skill->id);
      return new SkillResource($skill);
    }

    public function destroy(Skill $skill)
    {
      // validar con Token
      $skill->delete();
      return new SkillResource($skill);
    }
}
