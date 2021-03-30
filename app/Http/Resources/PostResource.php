<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'subject' => new SubjectResource($this->subject),
            'description' => $this->description,
            'address' => $this->address,
            'offer' => $this->offer,
            'tutor' => $this->tutor,
            'applicants' => UserResource::collection($this->whenLoaded('applicants'))
        ];
    }
}
