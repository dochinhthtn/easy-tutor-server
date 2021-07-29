<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = "user";
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
            'name' => $this->name,
            'email' => $this->email,
            'phoneNumber' => $this->phone_number,
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'role' => $this->role->name,
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects'))
        ];
    }

}
