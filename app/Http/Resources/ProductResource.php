<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "category_name" => $this->category->name ?? "",
            "salon_name" => $this->salon->name ?? "",
            "status" => $this->status,
            "price" => $this->price,
            "quantity" => $this->quantity,
            "image" => ImageResource::collection($this->images)
        ];
    }
}
