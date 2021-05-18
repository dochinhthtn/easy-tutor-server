<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
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
            'star' => $this->star,
            'comment' => $this->comment,
            'assessor' => $this->whenLoaded('assessor'),
            'tutor' => $this->whenLoaded('tutor'),
            'dateModified' => $this->created_at
        ];
    }
}
