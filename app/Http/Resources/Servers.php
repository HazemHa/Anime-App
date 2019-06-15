<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Episode;
class Servers extends JsonResource
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
            'episode_id' => $this->episode_id,
            'server_name' => $this->server_name,
            'episode_link' => $this->episode_link,
            'server_type'=>$this->server_type,
            'episode' => Episode::collection($this->whenLoaded('episode')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
