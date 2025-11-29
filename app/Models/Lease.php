<?php

namespace App\Models;

use App\Enums\LeaseStatus;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lease extends Model
{
    use HasFactory, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'apartment_id',
        'user_id',
        'monthly_rent',
        'cutoff_day',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monthly_rent' => 'integer',
            'cutoff_day' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => LeaseStatus::class,
        ];
    }

    /**
     * Get the apartment that owns the lease.
     */
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    /**
     * Get the user (tenant) that owns the lease.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payments for the lease.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only include active leases.
     */
    public function scopeActive($query)
    {
        return $query->where('status', LeaseStatus::ACTIVE);
    }

    /**
     * Scope a query to only include completed leases.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', LeaseStatus::COMPLETED);
    }

    /**
     * Scope a query to only include terminated leases.
     */
    public function scopeTerminated($query)
    {
        return $query->where('status', LeaseStatus::TERMINATED);
    }

    /**
     * Scope a query to filter by apartment.
     */
    public function scopeByApartment($query, $apartmentId)
    {
        return $query->where('apartment_id', $apartmentId);
    }

    /**
     * Scope a query to filter by user (tenant).
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter leases between dates.
     */
    public function scopeBetweenDates($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('start_date', '<=', $endDate);
        }

        return $query;
    }

    /**
     * Scope a query to get leases expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        $futureDate = Carbon::now()->addDays($days);

        return $query->where('status', LeaseStatus::ACTIVE)
            ->whereNotNull('end_date')
            ->whereBetween('end_date', [Carbon::now(), $futureDate]);
    }

    /**
     * Check if the lease is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === LeaseStatus::ACTIVE;
    }

    /**
     * Get the duration of the lease in months.
     */
    public function getDurationInMonths(): ?int
    {
        if (!$this->end_date) {
            return null;
        }

        return $this->start_date->diffInMonths($this->end_date);
    }

    /**
     * Get the duration of the lease in days.
     */
    public function getDurationInDays(): int
    {
        $endDate = $this->end_date ?? Carbon::now();
        return $this->start_date->diffInDays($endDate);
    }

    /**
     * Terminate the lease.
     */
    public function terminate(string $reason = 'terminated', ?string $notes = null): void
    {
        $this->update([
            'end_date' => Carbon::now(),
            'status' => $reason === 'completed' ? LeaseStatus::COMPLETED : LeaseStatus::TERMINATED,
            'notes' => $notes ? ($this->notes ? $this->notes . "\n\n" . $notes : $notes) : $this->notes,
        ]);

        // Update apartment
        $this->apartment->update([
            'user_id' => null,
            'status' => \App\Enums\ApartmentStatus::AVAILABLE,
        ]);

        // Update user status to inactive
        $this->user->update([
            'status' => 'inactive',
        ]);
    }

    /**
     * Get the formatted monthly rent.
     */
    public function getFormattedMonthlyRentAttribute(): string
    {
        return '$' . number_format($this->monthly_rent, 0, ',', '.');
    }

    /**
     * Get the status text.
     */
    public function getStatusTextAttribute(): string
    {
        return $this->status->label();
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return $this->status->badgeClass();
    }
}
