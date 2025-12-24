<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_ratings', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');

            // Rating data
            $table->tinyInteger('rating'); // 1–5
            $table->text('review')->nullable();

            $table->timestamps();

            // Constraints
            $table->unique(['course_id', 'user_id']);

            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_ratings');
    }
};
