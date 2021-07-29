<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'userId' => $this->user_id,
            'sex' => $this->sex,
            'address' => $this->address,
            'achievementDescription' => $this->achievement_description,
            'achievements' => FileResource::collection($this->whenLoaded('achievements')),
            'avatars' => FileResource::collection($this->whenLoaded('avatars')),
            'avatar' => FileResource::collection($this->whenLoaded('avatar'))->first()
        ];
    }
}
