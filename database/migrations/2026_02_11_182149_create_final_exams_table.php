<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('final_exams', function (Blueprint $table) {

        $table->id();

        // IMPORTANT (string because P00001)
        $table->string('course_id');

        // Instructor
        $table->unsignedBigInteger('instructor_id');

        $table->string('title');
        $table->text('description')->nullable();

        $table->integer('total_marks');
        $table->integer('passing_marks');

        $table->integer('duration_minutes');

        $table->enum('status', ['draft','published'])
              ->default('draft');

        $table->timestamp('published_at')->nullable();

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('final_exams');
    }
};
