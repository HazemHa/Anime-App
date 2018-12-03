<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User;
class Rating extends JsonResource
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
            'user_id' => $this->user_id,
            'rating_id' => $this->rating_id,
            'rating_type' => $this->rating_type,
            'item'=> $this->rating_type::where('id', $this->rating_id)->first(),
            'count'=>$this->count,
            'users'=> User::collection($this->whenLoaded('users')),
        ];
    }
}
