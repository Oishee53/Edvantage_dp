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
        // ── live_sessions ─────────────────────────────────────────────────────
        Schema::table('live_sessions', function (Blueprint $table) {
            // Drop Mux columns
            $table->dropColumn(['mux_stream_id', 'mux_playback_id', 'mux_asset_id']);

            // Add Daily + recording columns
            $table->string('daily_room_name')->nullable()->after('pdf');
            $table->string('daily_room_url')->nullable()->after('daily_room_name');
            $table->string('recording_url')->nullable()->after('daily_room_url');
        });

        // ── course_live_sessions ──────────────────────────────────────────────
        Schema::table('course_live_sessions', function (Blueprint $table) {
            // Drop Mux columns
            $table->dropColumn(['mux_stream_id', 'mux_playback_id', 'mux_asset_id']);

            // Add Daily + recording columns
            $table->string('daily_room_name')->nullable()->after('pdf');
            $table->string('daily_room_url')->nullable()->after('daily_room_name');
            $table->string('recording_url')->nullable()->after('daily_room_url');
        });
    }

    public function down(): void
    {
        Schema::table('live_sessions', function (Blueprint $table) {
            $table->dropColumn(['daily_room_name', 'daily_room_url', 'recording_url']);
            $table->string('mux_stream_id')->nullable();
            $table->string('mux_playback_id')->nullable();
            $table->string('mux_asset_id')->nullable();
        });

        Schema::table('course_live_sessions', function (Blueprint $table) {
            $table->dropColumn(['daily_room_name', 'daily_room_url', 'recording_url']);
            $table->string('mux_stream_id')->nullable();
            $table->string('mux_playback_id')->nullable();
            $table->string('mux_asset_id')->nullable();
        });
    }
};
