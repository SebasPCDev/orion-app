<?php

namespace App\Models;

use App\Enums\ApartmentStatus;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'price',
        'block',
        'description',
        'bedrooms',
        'bathrooms',
        'area',
        'floor',
        'unit_number',
        'amenities',
        'images',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'status' => ApartmentStatus::class,
            'area' => 'decimal:2',
            'amenities' => 'array',
            'images' => 'array',
        ];
    }

    /**
     * Get the user that owns the apartment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include available apartments.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', ApartmentStatus::AVAILABLE);
    }

    /**
     * Scope a query to only include rented apartments.
     */
    public function scopeRented($query)
    {
        return $query->where('status', ApartmentStatus::RENTED);
    }

    /**
     * Scope a query to filter by block.
     */
    public function scopeByBlock($query, $block)
    {
        return $query->where('block', $block);
    }

    /**
     * Get the formatted price (reference price).
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the current price (from active lease if rented, otherwise reference price).
     */
    public function getCurrentPriceAttribute(): int
    {
        if ($this->status === ApartmentStatus::RENTED && $this->relationLoaded('activeLease') && $this->activeLease) {
            return $this->activeLease->monthly_rent;
        }
        return $this->price;
    }

    /**
     * Get the formatted current price.
     */
    public function getFormattedCurrentPriceAttribute(): string
    {
        return '$' . number_format($this->current_price, 0, ',', '.');
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return $this->status->badgeClass();
    }

    /**
     * Get the status text.
     */
    public function getStatusTextAttribute(): string
    {
        return $this->status->label();
    }

    /**
     * Get the payments for the apartment.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the leases for the apartment.
     */
    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class);
    }

    /**
     * Get the active lease for the apartment.
     */
    public function activeLease()
    {
        return $this->hasOne(Lease::class)->where('status', \App\Enums\LeaseStatus::ACTIVE);
    }
}
