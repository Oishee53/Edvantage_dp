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
        Schema::table('final_exam_submissions', function (Blueprint $table) {
            $table->string('screen_recording_playback_id')->nullable()->after('webcam_playback_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_exam_submissions', function (Blueprint $table) {
            $table->dropColumn('screen_recording_playback_id');
        });
    }
};