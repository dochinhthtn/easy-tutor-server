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
            'user' => $this->user,
            'subject' => $this->subject,
            'description' => $this->description,
            'address' => $this->address,
            'offer' => $this->offer,
            'tutor' => $this->tutor,
            'applicants' => $this->whenLoaded('applicants')
        ];
    }
}
