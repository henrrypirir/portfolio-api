<?php

namespace Server\Http\Controllers;

use Server\Skill;
use Server\Http\Resources\SkillResource;
use Server\Http\Resources\SkillsCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function index()
    {
      try {
        $skills = Skill::all();
        return new SkillsCollection($skills);
      } catch (\Exception $e) {
        Log::critical("Could not show skills: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["skills"=>"Something was wrong"], 500);
      }

    }

    public function store(Request $request)
    {
      try {
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
      } catch (\Exception $e) {
        Log::critical("Could not create new skill: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["skill"=>"Something was wrong"], 500);
      }
    }

    public function show(Skill $skill)
    {
      try {
        $skill = Skill::findOrFail($skill->id);
        return new SkillResource($skill);
      } catch (\Exception $e) {
        Log::critical("Could not show specific skill: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["skill"=>"Something was wrong"], 500);
      }
    }

    public function destroy(Skill $skill)
    {
      try {
        // validar con Token
        $skill->delete();
        return new SkillResource($skill);
      } catch (\Exception $e) {
        Log::critical("Could not delete skill: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["skill"=>"Something was wrong"], 500);
      }
    }
}
