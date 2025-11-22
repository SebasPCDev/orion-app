<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Auditable;

    /**
     * Fields to exclude from audit logging.
     */
    protected array $auditExclude = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identification_number',
        'name',
        'phone',
        'email',
        'password',
        'role',
        'status',
        'payment_status',
        'backup_phone',
        'cutoff_day',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the apartments owned by the user.
     */
    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }

    public function apartment(): HasOne
    {
        return $this->hasOne(Apartment::class);
    }

    /**
     * Get the payments for the user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the current cutoff date for this tenant.
     * Returns the most recent cutoff date (could be this month or last month).
     */
    public function getCurrentCutoffDate(): ?Carbon
    {
        if (!$this->cutoff_day) {
            return null;
        }

        $today = Carbon::today();
        $cutoffDay = min($this->cutoff_day, $today->daysInMonth);

        // Create cutoff date for current month
        $cutoffDate = $today->copy()->day($cutoffDay)->startOfDay();

        // If we haven't reached this month's cutoff yet, use last month's
        if ($today->lt($cutoffDate)) {
            $lastMonth = $today->copy()->subMonth();
            $cutoffDay = min($this->cutoff_day, $lastMonth->daysInMonth);
            $cutoffDate = $lastMonth->day($cutoffDay)->startOfDay();
        }

        return $cutoffDate;
    }

    /**
     * Get the next cutoff date for this tenant.
     */
    public function getNextCutoffDate(): ?Carbon
    {
        if (!$this->cutoff_day) {
            return null;
        }

        $today = Carbon::today();
        $cutoffDay = min($this->cutoff_day, $today->daysInMonth);

        // Create cutoff date for current month
        $cutoffDate = $today->copy()->day($cutoffDay)->startOfDay();

        // If we've passed this month's cutoff, get next month's
        if ($today->gte($cutoffDate)) {
            $nextMonth = $today->copy()->addMonth();
            $cutoffDay = min($this->cutoff_day, $nextMonth->daysInMonth);
            $cutoffDate = $nextMonth->day($cutoffDay)->startOfDay();
        }

        return $cutoffDate;
    }

    /**
     * Check if tenant has a complete payment for the current period.
     */
    public function hasPaymentForCurrentPeriod(): bool
    {
        $currentCutoff = $this->getCurrentCutoffDate();
        $nextCutoff = $this->getNextCutoffDate();

        if (!$currentCutoff || !$nextCutoff) {
            return false;
        }

        // Get the apartment's price
        $apartment = $this->apartment;
        if (!$apartment) {
            return false;
        }

        // Check if there's a payment in the current period that covers the rent
        return $this->payments()
            ->where('apartment_id', $apartment->id)
            ->whereBetween('payment_date', [$currentCutoff, $nextCutoff->subDay()])
            ->where('amount', '>=', $apartment->price)
            ->exists();
    }

    /**
     * Get the number of days since the current cutoff date.
     */
    public function getDaysSinceCutoff(): int
    {
        $currentCutoff = $this->getCurrentCutoffDate();

        if (!$currentCutoff) {
            return 0;
        }

        return max(0, Carbon::today()->diffInDays($currentCutoff));
    }

    /**
     * Get the payment status for this tenant.
     * Returns: 'al_dia', 'pendiente', 'moroso', or null if not applicable.
     */
    public function getPaymentStatusCalculatedAttribute(): ?string
    {
        // Only applies to tenants with cutoff day and an apartment
        if ($this->role !== 'tenant' || !$this->cutoff_day || !$this->apartment) {
            return null;
        }

        // Check if has payment for current period
        if ($this->hasPaymentForCurrentPeriod()) {
            return 'al_dia';
        }

        // Calculate days since cutoff
        $daysSinceCutoff = $this->getDaysSinceCutoff();

        // More than 10 days = moroso
        if ($daysSinceCutoff > 10) {
            return 'moroso';
        }

        // 0-10 days = pendiente
        return 'pendiente';
    }

    /**
     * Get the payment status label in Spanish.
     */
    public function getPaymentStatusLabelAttribute(): ?string
    {
        return match ($this->payment_status_calculated) {
            'al_dia' => 'Al día',
            'pendiente' => 'Pendiente',
            'moroso' => 'Moroso',
            default => null,
        };
    }

    /**
     * Get the payment status color for badges.
     */
    public function getPaymentStatusColorAttribute(): ?string
    {
        return match ($this->payment_status_calculated) {
            'al_dia' => 'emerald',
            'pendiente' => 'amber',
            'moroso' => 'red',
            default => 'zinc',
        };
    }

    /**
     * Scope to filter tenants only.
     */
    public function scopeTenants($query)
    {
        return $query->where('role', 'tenant');
    }
}
