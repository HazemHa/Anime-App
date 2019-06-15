<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User;
class Notificaiton extends JsonResource
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
            'sender_id' =>$this->sender_id,
            'receiver_id' => $this->receiver_id,
            'senderInfo' => new  User($this->senderInfo),
            'receiverInfo' => new  User($this->receiverInfo),
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
