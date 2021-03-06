<?php

namespace Server\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
          'developer' => (new DeveloperResource($this->developer)),
          'skills' => (new ProjectSkillsRelationshipResource($this->skills)),
      ];
    }
}
