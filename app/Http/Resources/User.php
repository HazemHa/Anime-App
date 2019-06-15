<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment;
use App\Http\Resources\Favorite;
use App\Http\Resources\Like;
use App\Http\Resources\Notificaiton;

class User extends JsonResource
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
            'role_id'=>$this->role_id,
            'avatar'=>$this->avater,
            'name' => $this->name,
            'email' => $this->email,
            'comments' => Comment::collection($this->whenLoaded('comments')),
            'favorites' => Favorite::collection($this->whenLoaded('favorites')),
            'likes' => Like::collection($this->whenLoaded('likes')),
            'notifications' => Notificaiton::collection($this->whenLoaded('notifications')),
       //     'remember_token'=>$this->remember_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
