<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $photo = $this->photo ? asset("storage/photo/" . $this->photo) : asset("image/user-default.jpg");
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "created_at_date" =>  $this->created_at->format('d-m-Y'),
            "created_at_time" => $this->created_at->format('H:i:s'),
            "photo" => $photo
        ];
    }
}
