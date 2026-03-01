<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('live_sessions', function (Blueprint $table) {
            $table->string('recording_url')->nullable()->after('status');
        });

        // Also add to course_live_sessions if that's a separate table
        Schema::table('course_live_sessions', function (Blueprint $table) {
            $table->string('recording_url')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_sessions', function (Blueprint $table) {
            //
        });
    }
};
