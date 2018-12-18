<?php

namespace Server\Http\Controllers;

use Server\Skill;
use Server\Http\Resources\SkillsCollection;
use Illuminate\Http\Request;

class SkillController extends Controller
{

     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $skills = Skill::all();
      return new SkillsCollection($skills);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Server\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Server\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
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
