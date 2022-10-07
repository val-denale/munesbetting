<?php

namespace App\Http\Resources\Admin;

use App\Models\Sport;
use Illuminate\Http\Resources\Json\JsonResource;

class BetsResource extends JsonResource
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
            'id' => $this->id,
          'name' => $this->name,
          'odd' => $this->odd,
          'state' => $this->state,
          'sport' => SportResource::make($this->sport),
        ];
    }
}
