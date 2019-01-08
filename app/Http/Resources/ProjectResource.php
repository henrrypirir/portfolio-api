<?php

namespace Server\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
          'type'          => 'projects',
          'id'            => (string)$this->id,
          'attributes'    => [
              'title' => $this->title,
              'description' => $this->description,
              'website' => $this->website,
              'country' => $this->country,
              'published_at' => $this->published_at,
              'published' => $this->published,
          ],
          'relationships' => new ProjectRelationshipResource($this),
          'links'         => [
            'self' => route('projects.show', ['project' => $this->id]),
          ],
        ];
    }
}
