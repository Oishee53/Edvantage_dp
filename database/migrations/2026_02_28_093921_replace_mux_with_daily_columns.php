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

        if (Schema::hasColumn('live_sessions', 'mux_stream_id')) {
            $table->dropColumn('mux_stream_id');
        }

        if (Schema::hasColumn('live_sessions', 'mux_playback_id')) {
            $table->dropColumn('mux_playback_id');
        }

        if (Schema::hasColumn('live_sessions', 'mux_asset_id')) {
            $table->dropColumn('mux_asset_id');
        }

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
