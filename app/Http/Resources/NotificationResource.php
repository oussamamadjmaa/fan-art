<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $translation_data = collect($this->notifiable)->reject(function($a) {
            return is_array($a);
        })->toArray();

        $translation_data['fromUser_name'] = $this->from_user->name;

        return [
            'id' => $this->id,
            'from_user_id' => $this->from_user_id,
            'to_user_id' => $this->to_user_id,
            'from_user' => $this->from_user->only('id', 'name', 'avatar', 'avatar_url'),
            'notifiable_id' => $this->notifiable_id,
            'notifiable_type' => $this->notifiable_type,
            'seen_at' => $this->seen_at,
            'seen' => !is_null($this->seen_at),
            'type' => $this->type,
            'title' => __("db_notifications.{$this->type}.title"),
            'description' => __("db_notifications.{$this->type}.description", $translation_data),
            'icon' => __("db_notifications.{$this->type}.icon"),
            'bg_class' => __("db_notifications.{$this->type}.bg_class"),
            'created_at_for_humans' => $this->created_at->diffForHumans(),
            'created_at' => $this->created_at->translatedFormat('d M y h:i A'),
            'updated_at' => $this->updated_at->translatedFormat('d M y h:i A'),
        ];
    }
}
