<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "project" => [
                "id" => $this->id,
                "name" => $this->name,
                "description" => $this->description,
            ],
            "relationship" => [
                "id" => $this->author->id,
                "name" => $this->author->name,
                "email" => $this->author->email,
                "role" => $this->author->role,
                "phone_no" => $this->author->phone_no
            ]
        ];
    }
}
