<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'hotel' => [
                'id' => $this->hotel?->id,
                'title' => $this->hotel?->title,
                'slug' => $this->hotel?->slug,
            ],

            'room' => [
                'id' => $this->room?->id,
                'type' => $this->room?->type,
                'slug' => $this->room?->slug,
            ],

            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'guests' => $this->guests,
            'meal_plan' => $this->meal_plan,

            'total_price' => $this->total_price,

            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'paid_at' => $this->paid_at,
        ];
    }
}