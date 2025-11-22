<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

class AuditLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'event',
        'old_values',
        'new_values',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }

    /**
     * Get the auditable model.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who made the change.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event label in Spanish.
     */
    public function getEventLabelAttribute(): string
    {
        return match ($this->event) {
            'created' => 'Creado',
            'updated' => 'Actualizado',
            'deleted' => 'Eliminado',
            default => $this->event,
        };
    }

    /**
     * Get the event color for badges.
     */
    public function getEventColorAttribute(): string
    {
        return match ($this->event) {
            'created' => 'emerald',
            'updated' => 'blue',
            'deleted' => 'red',
            default => 'zinc',
        };
    }

    /**
     * Get the model name in a readable format.
     */
    public function getModelNameAttribute(): string
    {
        $class = class_basename($this->auditable_type);

        return match ($class) {
            'Apartment' => 'Apartamento',
            'User' => 'Usuario',
            'Payment' => 'Pago',
            default => $class,
        };
    }

    /**
     * Get the changed fields between old and new values.
     */
    public function getChangedFieldsAttribute(): array
    {
        if ($this->event === 'created') {
            return array_keys($this->new_values ?? []);
        }

        if ($this->event === 'deleted') {
            return array_keys($this->old_values ?? []);
        }

        $changes = [];
        $oldValues = $this->old_values ?? [];
        $newValues = $this->new_values ?? [];

        foreach ($newValues as $key => $newValue) {
            $oldValue = $oldValues[$key] ?? null;
            if ($oldValue !== $newValue) {
                $changes[] = $key;
            }
        }

        return $changes;
    }

    /**
     * Scope to filter by auditable type.
     */
    public function scopeForModel(Builder $query, string $model): Builder
    {
        return $query->where('auditable_type', $model);
    }

    /**
     * Scope to filter by event type.
     */
    public function scopeByEvent(Builder $query, string $event): Builder
    {
        return $query->where('event', $event);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeBetweenDates(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $query;
    }

    /**
     * Scope to get recent logs.
     */
    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
