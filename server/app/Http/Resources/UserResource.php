<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $data = [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'admin' => $this->isAdmin(),
            'free_access' => $this->free_access,
            'created_at' => $this->created_at->format('d/m/Y'),
            'subscribed' => $this->subscribed('default'),
            'ends_at' => optional(optional($this->subscription('default'))->ends_at)->format('d/m/Y'),
            'next_billing_date' => $this->getNextBillingDate(),
            'plan' => new PlanResource($this->plan)
        ];

        return $data;
    }
}
