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
        Schema::create('final_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('final_exam_submissions')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('final_exam_questions')->onDelete('cascade');
            $table->json('answer_images')->nullable(); // array of Cloudinary URLs
            $table->decimal('marks_obtained', 8, 2)->nullable();
            $table->text('instructor_comment')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('submission_id');
            $table->index('question_id');
            
            // Unique: one answer per question per submission
            $table->unique(['submission_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_exam_answers');
    }
};