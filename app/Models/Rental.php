<?php

namespace App\Models;

use Database\Factories\RentalFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'fleet_id',
    'start_date',
    'end_date',
    'return_date',
    'daily_rate',
    'total_days',
    'total_price',
    'penalty_price',
    'status',
    'notes',
])]
class Rental extends Model
{
    /** @use HasFactory<RentalFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'return_date' => 'date',
            'total_days' => 'integer',
        ];
    }

    /**
     * Get the user that owns the rental.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the fleet car that was rented.
     */
    public function fleet(): BelongsTo
    {
        return $this->belongsTo(Fleet::class);
    }
}
