<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any null or invalid values to 'active'
        DB::table('users')
            ->whereNull('status')
            ->orWhereNotIn('status', ['active', 'inactive'])
            ->update(['status' => 'active']);

        // Change column to enum
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->nullable()->change();
        });
    }
};
