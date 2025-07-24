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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->decimal('price', 10, 2);
            $table->boolean('is_rented')->default(false);
            $table->string('block')->nullable(); // Para agrupar apartamentos por bloque
            $table->text('description')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->foreignId('user_id')->nullable()->unique()->constrained()->onDelete('set null');
            $table->decimal('area', 8, 2)->nullable(); // Área en metros cuadrados
            $table->string('floor')->nullable();
            $table->string('unit_number')->nullable();
            $table->json('amenities')->nullable(); // Array de amenidades
            $table->string('status')->default('available'); // available, rented, maintenance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
