<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtistsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'phone' => $this->phone,
            'country' => __(country($this->country)->getName()),
            'nationality' => __($this->nationality),
            'gender' => __($this->gender),
            "website" => $this->website,
            "avatar" => $this->avatar,
            "type" => __($this->artist_type),
            "avatar_url" => $this->avatar_url
        ];
    }
}
