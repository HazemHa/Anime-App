<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as JsonUser;
use App\User;
use App\Http\Resources\Group;
use App\Http\Resources\Episode;
class Comment extends JsonResource
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
            'user' => new JsonUser($this->user),
            'body' => $this->body,
            'name' => $this->name,
            /*
            'episode' => $this->when(
                $this->commenttable_type == 'App\Episode',
                new Episode($this->commenttable)
            ),
            'group' => $this->when($this->commenttable_type == 'App\Group', new Group($this->commenttable)),
            */
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
