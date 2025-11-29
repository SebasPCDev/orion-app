<?php

namespace App\Models;

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
        'is_rented',
        'block',
        'description',
        'bedrooms',
        'bathrooms',
        'area',
        'floor',
        'unit_number',
        'amenities',
        'images', // Agregar este campo
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
            'is_rented' => 'boolean',
            'area' => 'decimal:2',
            'amenities' => 'array',
            'images' => 'array',
        ];
    }

    /**
     * Sincroniza is_rented con status cuando se actualiza is_rented.
     */
    public function setIsRentedAttribute($value)
    {
        $this->attributes['is_rented'] = $value;

        // Sincronizar status solo si no esta en mantenimiento
        if (!isset($this->attributes['status']) || $this->attributes['status'] !== 'maintenance') {
            $this->attributes['status'] = $value ? 'rented' : 'available';
        }
    }

    /**
     * Sincroniza is_rented con status cuando se actualiza status.
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;

        // Sincronizar is_rented basado en status
        if ($value === 'rented') {
            $this->attributes['is_rented'] = true;
        } elseif ($value === 'available') {
            $this->attributes['is_rented'] = false;
        }
        // Si es 'maintenance', no cambiamos is_rented
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
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include rented apartments.
     */
    public function scopeRented($query)
    {
        return $query->where('is_rented', true);
    }

    /**
     * Scope a query to filter by block.
     */
    public function scopeByBlock($query, $block)
    {
        return $query->where('block', $block);
    }

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return $this->is_rented 
            ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
            : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
    }

    /**
     * Get the status text.
     */
    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            'rented' => 'Arrendado',
            'maintenance' => 'En Mantenimiento',
            default => 'Disponible',
        };
    }

    /**
     * Get the payments for the apartment.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
