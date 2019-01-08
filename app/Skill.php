<?php

namespace Server;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    //
    public function projects()
    {
      return $this->belongsToMany('Server\Project', 'project_skill');
    }
}
