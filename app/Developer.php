<?php

namespace Server;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{

  public function user()
  {
      return $this->belongsTo('Server\User', 'user_id');
  }
}
