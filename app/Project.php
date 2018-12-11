<?php

namespace Server;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function skills()
    {
      return $this->belongsToMany('Server\Skill', 'project_skill');
    }
}
