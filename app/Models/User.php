<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'driving_license_number',
    'driving_license_expiry_date',
    'driving_license_photo',
    'phone_number',
    'address',
    'role',
    'verification_status',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'driving_license_expiry_date' => 'date',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the rentals for the user.
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the driving license photo full URL.
     */
    public function getDrivingLicensePhotoUrlAttribute(): ?string
    {
        if (! $this->driving_license_photo) {
            return null;
        }

        if (str_starts_with($this->driving_license_photo, 'http://') || str_starts_with($this->driving_license_photo, 'https://')) {
            return $this->driving_license_photo;
        }

        $path = ltrim(str_replace('public/storage/', '', $this->driving_license_photo), '/');

        return asset('storage/'.$path);
    }

    /**
     * Check if user SIM A is verified.
     */
    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
