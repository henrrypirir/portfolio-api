<?php

namespace Server\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeveloperResource extends JsonResource
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
        'type'          => 'developer',
        'id'            => (string)$this->id,
        'attributes'    => [
            'label' => $this->label,
            'phone' => $this->phone,
            'website' => $this->website,
            'summary' => $this->summary,
            'address' => $this->address,
            'region' => $this->region,
            'country' => $this->country,
        ],
        // 'relationships' => new StudentRelationshipResource($this),
        'links'         => [
          'self' => route('developers.show', ['developer' => $this->id]),
        ],
      ];
    }
}
