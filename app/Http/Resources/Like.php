<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Group;
use App\Http\Resources\Episode;
class Like extends JsonResource
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
     //       'id' => $this->id,
            'user_id'=>$this->user_id,
            'episode' => $this->when(
                $this->likestable_type == 'App\Episode',
                new Episode($this->likestable)
            ),
            'group' => $this->when($this->likestable_type == 'App\Group', new Group($this->likestable)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
       
    }
}
