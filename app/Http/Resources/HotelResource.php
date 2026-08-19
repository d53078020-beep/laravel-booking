<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'location' => $this->location,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'rate' => $this->rate,
            'room' => $this->price,

            'category' => [
                'id' => $this->category?->id,
                'title' => $this->category?->title,
                'slug' => $this->category?->slug,
            ],
            'rooms' => RoomResource::collection(
                $this->whenLoaded('rooms')
            ),
        ];
    }
}
