<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_live_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->onDelete('cascade');
            $table->unsignedInteger('session_number');
            $table->string('title')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->unsignedInteger('duration_minutes');
            $table->string('pdf')->nullable();             // Cloudinary URL
            $table->string('mux_stream_id')->nullable();   // filled when session starts
            $table->string('mux_playback_id')->nullable(); // filled after stream ends (rewatch)
            $table->string('mux_asset_id')->nullable();    // filled via Mux webhook
            $table->enum('status', ['scheduled', 'live', 'ended'])->default('scheduled');
            $table->timestamps();

            $table->unique(['course_id', 'session_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_live_sessions');
    }
};