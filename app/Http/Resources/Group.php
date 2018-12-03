<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment;
use App\Http\Resources\Favorite;
use App\Http\Resources\Like;
use App\Http\Resources\Episode;
use App\Http\Resources\GroupType;
class Group extends JsonResource
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
            'comments' => Comment::collection($this->whenLoaded('comments')),
            'favorites' => Favorite::collection($this->whenLoaded('favorites')),
            'likes' => Like::collection($this->whenLoaded('likes')),
            'episodes' => Episode::collection($this->whenLoaded('episodes')),
            'ratings' => Rating::collection($this->whenLoaded('ratings')),
            'name'=>$this->name,
            'description'=>$this->description,
            'image'=>$this->image,
            'views'=>$this->views,
            'groupTypeName'=> new GroupType($this->groupName),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'meta' =>$this->with($request),
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
            'tmprating'=>5,
            'tmpshow' => false,
        ];
    }
}
