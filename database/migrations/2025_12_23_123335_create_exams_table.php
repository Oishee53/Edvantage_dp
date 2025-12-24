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
        Schema::create('final_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('total_marks');
            $table->integer('passing_marks'); // 70% of total_marks
            $table->integer('duration_minutes')->default(180); // 3 hours default
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('course_id');
            $table->index('instructor_id');
            $table->index('status');
            
            // Unique: One exam per course
            $table->unique('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_exams');
    }
};