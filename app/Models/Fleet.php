<?php

namespace App\Models;

use Database\Factories\FleetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'brand',
    'type',
    'model',
    'year',
    'color',
    'plate_number',
    'transmission',
    'fuel_type',
    'seat_capacity',
    'price',
    'availability',
    'image',
])]
class Fleet extends Model
{
    /** @use HasFactory<FleetFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'seat_capacity' => 'integer',
        ];
    }

    /**
     * Get the rentals for the fleet car.
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
