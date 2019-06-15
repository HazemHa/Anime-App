<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Group;
use App\Http\Resources\Episode;
class Favorite extends JsonResource
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
       //     'id' => $this->id,
            'user_id' => $this->user_id,
            'episode' => $this->when(
                $this->favoritetable_type == 'App\Episode',
                new Episode($this->favoritetable)),
            'group'=> $this->when($this->favoritetable_type == 'App\Group', new Group($this->favoritetable)),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
