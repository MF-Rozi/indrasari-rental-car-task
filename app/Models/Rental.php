<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\RentalFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'rental_code',
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
            'daily_rate' => 'decimal:2',
            'total_price' => 'decimal:2',
            'penalty_price' => 'decimal:2',
        ];
    }

    /**
     * Calculate inclusive calendar rental days between two dates.
     * Formula: (End Date - Start Date) + 1 Day.
     */
    public static function calculateInclusiveDays(Carbon|string $startDate, Carbon|string $endDate): int
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        if ($end->lt($start)) {
            return 1;
        }

        return (int) $start->diffInDays($end) + 1;
    }

    /**
     * Calculate total rental price.
     */
    public static function calculateTotalPrice(float|int $dailyRate, int $days): float
    {
        return (float) ($dailyRate * max(1, $days));
    }

    /**
     * Generate a unique standardized rental transaction code.
     * Format: IND-BK-YYYYMM-XXXX (e.g. IND-BK-202608-4821)
     */
    public static function generateRentalCode(): string
    {
        $prefix = 'IND-BK-'.now()->format('Ym').'-';

        do {
            $code = $prefix.str_pad((string) mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (static::where('rental_code', $code)->exists());

        return $code;
    }

    /**
     * Check if the active rental has exceeded its agreed end date.
     */
    public function isOverdue(): bool
    {
        if (! in_array($this->status, ['active', 'pending_return'], true)) {
            return false;
        }

        return now()->startOfDay()->gt($this->end_date->startOfDay());
    }

    /**
     * Calculate number of days overdue.
     */
    public function daysOverdue(): int
    {
        if (! $this->isOverdue()) {
            return 0;
        }

        return (int) $this->end_date->startOfDay()->diffInDays(now()->startOfDay());
    }

    /**
     * Calculate late fee based on days overdue and daily rate.
     */
    public function calculateLateFee(): float
    {
        $days = $this->daysOverdue();

        return (float) ($days * (float) $this->daily_rate);
    }

    /**
     * Determine if this rental can be cancelled by the user.
     * Allowed only if status is active/pending and start date is in the future.
     */
    public function isCancellable(): bool
    {
        if ($this->status === 'cancelled' || $this->status === 'completed') {
            return false;
        }

        return now()->startOfDay()->lt($this->start_date->startOfDay());
    }

    /**
     * Determine if the rental is pending admin return inspection.
     */
    public function isPendingReturn(): bool
    {
        return $this->status === 'pending_return';
    }

    /**
     * Determine if the rental is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Formatted total price in IDR currency.
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp '.number_format((float) $this->total_price, 0, ',', '.');
    }

    /**
     * Formatted daily rate in IDR currency.
     */
    public function getFormattedDailyRateAttribute(): string
    {
        return 'Rp '.number_format((float) $this->daily_rate, 0, ',', '.');
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
