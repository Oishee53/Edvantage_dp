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
        Schema::create('final_exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('final_exam_id')->constrained('final_exams')->onDelete('cascade');
            $table->integer('question_number'); // 1, 2, 3...
            $table->text('question_text');
            $table->integer('marks'); // marks for this question
            $table->text('marking_criteria')->nullable(); // optional grading guidelines
            $table->timestamps();

            // Indexes
            $table->index('final_exam_id');
            
            // Unique: one question per exam per question number
            $table->unique(['final_exam_id', 'question_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_exam_questions');
    }
};