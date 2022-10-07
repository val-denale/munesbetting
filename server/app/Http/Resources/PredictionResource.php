<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\BetsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PredictionResource extends JsonResource
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
            'free' => $this->isFree(),
            'analyse' => $this->analyse,
            'total_odd' => $this->total_odd,
            'current_state' => $this->current_state,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at->diffForHumans(),
            'bets' => BetsResource::collection($this->bets)
        ];
    }
}
