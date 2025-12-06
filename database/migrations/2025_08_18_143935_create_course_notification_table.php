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
        Schema::create('course_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('pending_course_id'); // course id as string
            $table->unsignedBigInteger('instructor_id'); // instructor id
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // notification status
            $table->boolean('is_read')->default(false); // unread by default
            $table->timestamps();

            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_notifications');
    }
};
