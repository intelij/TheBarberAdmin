<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "address" => $this->address,
            "contact" => $this->contact,
            "city" => $this->city,
            "state" => $this->state,
            "country" => $this->country,
            "payment_id" => $this->payment_id,
            "product_id" => $this->product_id,
            "price" => $this->price,
            "quantity" => $this->quantity,
            'tracking_no' => $this->tracking_no,
            "user" => $this->user,
            'status' => $this->status->value ?? "",
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
