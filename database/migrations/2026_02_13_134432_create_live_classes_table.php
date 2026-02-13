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
        Schema::create('live_classes', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('course_id');
    $table->unsignedBigInteger('instructor_id');
    $table->string('title');
    $table->dateTime('schedule_datetime');
    $table->string('meeting_link');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_classes');
    }
};
