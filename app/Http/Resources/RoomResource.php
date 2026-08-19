<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'type' => $this->type,
            'slug' => $this->slug,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'quantity_rooms' => $this->quantity_rooms,
            'status' => $this->status,

            'meal_prices' => [
                'breakfast_price' => $this->breakfast_price,
                'half_board_price' => $this->half_board_price,
                'all_inclusive_price' => $this->all_inclusive_price,
            ],
        ];
        // return parent::toArray($request);
    }
}
