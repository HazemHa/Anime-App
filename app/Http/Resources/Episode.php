<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment;
use App\Http\Resources\Favorite;
use App\Http\Resources\Like;
use App\Http\Resources\Group;
use App\Http\Resources\Rating;
use App\Http\Resources\Servers;

class Episode extends JsonResource
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
            'group_id' => $this->group_id,
            'number' => $this->number,
            'description' => $this->description,
            'group'=> new Group($this->group),
            'comments' => Comment::collection($this->whenLoaded('comments')),
            'favorites' =>  Favorite::collection($this->whenLoaded('favorites')),
            'likes' =>  Like::collection($this->whenLoaded('likes')),
            'ratings'=> Rating::collection($this->whenLoaded('ratings')),
            'servers'=> $this->serversAs($request),
            'image'=>$this->image,
            'views'=>$this->views,
            'rating'=>$this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'meta' => $this->with($request),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'tmprating' => 5,
            'tmpshow' => false,
            'like'=>true,
            'favorite'=>true,
        ];
    }
    public function serversAs($request){
       return ['download'=>Servers::collection($this->downloads()),
                'upload'=> Servers::collection($this->uploads())
            ];
    }

    public function downloads(){
        return $this->servers()->where('server_type', 'download')->get();
    }
    public function uploads(){
        return $this->servers()->where('server_type', 'upload')->get();
    }
}
