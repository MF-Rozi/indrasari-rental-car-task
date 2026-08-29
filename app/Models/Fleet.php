<?php

namespace App\Models;

use Database\Factories\FleetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    'images',
])]
class Fleet extends Model
{
    /** @use HasFactory<FleetFactory> */
    use HasFactory, SoftDeletes;

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
            'images' => 'array',
        ];
    }

    /**
     * Get the full display name of the car.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model}";
    }

    /**
     * Get primary image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'public/')) {
            return asset($this->image);
        }

        return asset('storage/'.$this->image);
    }

    /**
     * Get full list of gallery image URLs.
     */
    public function getGalleryUrlsAttribute(): array
    {
        $urls = [];
        if (! empty($this->images) && is_array($this->images)) {
            foreach ($this->images as $img) {
                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                    $urls[] = $img;
                } elseif (str_starts_with($img, 'public/')) {
                    $urls[] = asset($img);
                } else {
                    $urls[] = asset('storage/'.$img);
                }
            }
        }

        return $urls;
    }

    /**
     * Get the rentals for the fleet car.
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
