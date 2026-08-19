<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Hotel;

class AiAssistantController extends Controller
{
    public function test()
    {
        $hotels = Hotel::query()
            ->with(['category', 'rooms'])
            ->get();

        $hotelData = $hotels->map(function ($hotel) {
            return [
                'hotel' => $hotel->title,
                'location' => $hotel->location,
                'category' => $hotel->category?->title,
                'price' => $hotel->price,
                'rating' => $hotel->rate,
                'rooms' => $hotel->rooms->map(function ($room) {
                    return [
                        'type' => $room->type,
                        'price' => $room->price,
                        'capacity' => $room->capacity,
                        'quantity_rooms' => $room->quantity_rooms,
                    ];
                })->toArray(),
            ];
        })->toArray();

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-5.4-mini',

                'input' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an AI hotel assistant for StayBook.
                    Recommend hotels and rooms ONLY from the provided database.
                    Never invent hotels or rooms.
                    Explain briefly why the recommendation fits the user.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "I need a hotel for 2 people in Prague under $200 per night.

Available hotels:
" . json_encode($hotelData, JSON_PRETTY_PRINT),
                    ],
                ],
            ]);

        $data = $response->json();

        return $data['output'][0]['content'][0]['text'];
    }



    public function ask(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $hotels = Hotel::query()
            ->with(['category', 'rooms'])
            ->get();

        $hotelData = $hotels->map(function ($hotel) {
            return [
                'hotel' => $hotel->title,
                'slug' => $hotel->slug,
                'location' => $hotel->location,
                'category' => $hotel->category?->title,
                'price' => $hotel->price,
                'rating' => $hotel->rate,

                'rooms' => $hotel->rooms->map(function ($room) {
                    return [
                        'type' => $room->type,
                        'price' => $room->price,
                        'capacity' => $room->capacity,
                        'quantity_rooms' => $room->quantity_rooms,
                    ];
                })->toArray(),
            ];
        })->toArray();

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-5.4-mini',

                'input' => [
                    [
                        'role' => 'system',
                        'content' => '
                        You are the StayBook AI hotel assistant.

                        Help users choose hotels and rooms.

                        Rules:
                        - Recommend ONLY hotels and rooms from the provided database.
                        - Never invent hotels, rooms, prices, ratings, slugs or locations.
                        - Consider budget, location, guest count, category and rating.
                        - Recommend a maximum of 3 hotels.
                        - hotel_slug MUST exactly match the slug from the supplied database.
                        - Give a short explanation for every recommendation.
                    ',
                    ],

                    [
                        'role' => 'user',
                        'content' =>
                        $request->message .
                            "\n\nAvailable hotels:\n" .
                            json_encode($hotelData, JSON_PRETTY_PRINT),
                    ],
                ],

                'text' => [
                    'format' => [
                        'type' => 'json_schema',
                        'name' => 'hotel_recommendations',
                        'strict' => true,

                        'schema' => [
                            'type' => 'object',

                            'properties' => [
                                'message' => [
                                    'type' => 'string',
                                ],

                                'recommendations' => [
                                    'type' => 'array',

                                    'items' => [
                                        'type' => 'object',

                                        'properties' => [
                                            'hotel_name' => [
                                                'type' => 'string',
                                            ],

                                            'hotel_slug' => [
                                                'type' => 'string',
                                            ],

                                            'location' => [
                                                'type' => 'string',
                                            ],

                                            'room_type' => [
                                                'type' => 'string',
                                            ],

                                            'price' => [
                                                'type' => 'number',
                                            ],

                                            'rating' => [
                                                'type' => 'number',
                                            ],

                                            'reason' => [
                                                'type' => 'string',
                                            ],
                                        ],

                                        'required' => [
                                            'hotel_name',
                                            'hotel_slug',
                                            'location',
                                            'room_type',
                                            'price',
                                            'rating',
                                            'reason',
                                        ],

                                        'additionalProperties' => false,
                                    ],
                                ],
                            ],

                            'required' => [
                                'message',
                                'recommendations',
                            ],

                            'additionalProperties' => false,
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'AI assistant is temporarily unavailable.',
            ], 500);
        }

        $data = $response->json();

        $text = $data['output'][0]['content'][0]['text'];

        $aiResult = json_decode($text, true);

        return response()->json($aiResult);
    }
}
