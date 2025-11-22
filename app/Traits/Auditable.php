<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    /**
     * Flag to disable auditing temporarily.
     */
    protected static bool $auditingDisabled = false;

    /**
     * Boot the Auditable trait.
     */
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            if (!static::$auditingDisabled) {
                $model->logAudit('created', [], $model->getAuditableAttributes());
            }
        });

        static::updated(function ($model) {
            if (!static::$auditingDisabled) {
                $oldValues = $model->getOriginalAuditableAttributes();
                $newValues = $model->getAuditableAttributes();

                // Solo registrar si hay cambios reales
                if ($oldValues !== $newValues) {
                    $model->logAudit('updated', $oldValues, $newValues);
                }
            }
        });

        static::deleted(function ($model) {
            if (!static::$auditingDisabled) {
                $model->logAudit('deleted', $model->getAuditableAttributes(), []);
            }
        });
    }

    /**
     * Get the audit logs for this model.
     */
    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    /**
     * Create an audit log entry.
     */
    protected function logAudit(string $event, array $oldValues, array $newValues): void
    {
        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->getKey(),
            'event' => $event,
            'old_values' => !empty($oldValues) ? $oldValues : null,
            'new_values' => !empty($newValues) ? $newValues : null,
            'user_id' => Auth::id(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Get the attributes to audit, excluding sensitive fields.
     */
    protected function getAuditableAttributes(): array
    {
        $attributes = $this->getAttributes();

        // Remove excluded fields
        foreach ($this->getAuditExclude() as $field) {
            unset($attributes[$field]);
        }

        // Remove timestamp fields if configured
        if ($this->shouldExcludeTimestamps()) {
            unset($attributes['created_at'], $attributes['updated_at']);
        }

        return $attributes;
    }

    /**
     * Get the original attributes before update, excluding sensitive fields.
     */
    protected function getOriginalAuditableAttributes(): array
    {
        $original = $this->getOriginal();

        foreach ($this->getAuditExclude() as $field) {
            unset($original[$field]);
        }

        if ($this->shouldExcludeTimestamps()) {
            unset($original['created_at'], $original['updated_at']);
        }

        return $original;
    }

    /**
     * Get fields to exclude from audit.
     * Override this property in your model to customize.
     */
    protected function getAuditExclude(): array
    {
        return property_exists($this, 'auditExclude') ? $this->auditExclude : [];
    }

    /**
     * Whether to exclude timestamps from audit.
     * Override this property in your model to customize.
     */
    protected function shouldExcludeTimestamps(): bool
    {
        return property_exists($this, 'auditExcludeTimestamps')
            ? $this->auditExcludeTimestamps
            : true;
    }

    /**
     * Get the latest audit log for this model.
     */
    public function getLatestAuditAttribute(): ?AuditLog
    {
        return $this->auditLogs()->latest()->first();
    }

    /**
     * Disable auditing temporarily.
     */
    public static function withoutAuditing(callable $callback): mixed
    {
        static::$auditingDisabled = true;

        try {
            return $callback();
        } finally {
            static::$auditingDisabled = false;
        }
    }

}
