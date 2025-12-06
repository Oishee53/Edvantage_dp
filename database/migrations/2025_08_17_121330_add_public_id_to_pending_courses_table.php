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
        // Step 1: Drop the current id
        Schema::table('pending_courses', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        // Step 2: Add string-based id with prefix
        Schema::table('pending_courses', function (Blueprint $table) {
            $table->string('id')->primary()->first();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_courses', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('pending_courses', function (Blueprint $table) {
            $table->id()->first();
        });
    }
};
