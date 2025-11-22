<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // Relación polimórfica con el modelo auditado
            $table->string('auditable_type');
            $table->unsignedBigInteger('auditable_id');

            // Tipo de evento
            $table->enum('event', ['created', 'updated', 'deleted']);

            // Valores anteriores y nuevos (JSON)
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Usuario que realizó el cambio
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Contexto adicional
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Índices para mejorar consultas
            $table->index(['auditable_type', 'auditable_id']);
            $table->index('event');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
