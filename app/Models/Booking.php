<?php

namespace App\Models;


use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;
    
    protected $fillable = ['hotel_id', 'room_id', 'user_id', 'check_in', 'check_out', 'guests', 'meal_plan', 'total_price', 'status', 'hotel',
    'payment_status', 'paid_at',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'paid_at' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }
}
