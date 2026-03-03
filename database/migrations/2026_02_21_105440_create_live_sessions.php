<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->foreign('course_id')
                ->references('id')
                ->on('pending_courses')
                ->onDelete('cascade');
            $table->unsignedInteger('session_number');
            $table->string('title')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->unsignedInteger('duration_minutes');
            $table->string('pdf')->nullable();
            $table->string('mux_stream_id')->nullable();
            $table->string('mux_playback_id')->nullable();
            $table->string('mux_asset_id')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended'])->default('scheduled');
            $table->timestamps();

            $table->unique(['course_id', 'session_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_sessions');
    }
};