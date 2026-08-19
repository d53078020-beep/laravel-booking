<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use Sluggable, SoftDeletes, HasFactory;

    protected $fillable = [
        'hotel_id',
        'type',
        'slug',
        'image',
        'description',
        'price',
        'capacity',
        'quantity_rooms',
        'status',
        'breakfast_price',
        'half_board_price',
        'all_inclusive_price'
    ];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'type'
            ]
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
