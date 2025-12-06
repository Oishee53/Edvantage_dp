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
        Schema::create('pending_courses', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('category')->nullable(); // Removed ->after()
            $table->integer('video_count');
            $table->string('approx_video_length'); // e.g., "8-10 mins"
            $table->string('total_duration'); // e.g., "3 hours"
            $table->decimal('price', 8, 2); // e.g., 999.99
            $table->string('prerequisite')->nullable(); // moved here for cleaner structure
            $table->foreignId('instructor_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_courses');
    }
};
