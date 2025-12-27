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
        Schema::create('final_exam_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('final_exam_id')->constrained('final_exams')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'submitted', 'graded'])->default('not_started');
            $table->decimal('total_score', 8, 2)->nullable(); // actual score obtained
            $table->decimal('percentage', 5, 2)->nullable(); // percentage score
            $table->text('instructor_feedback')->nullable();
            $table->timestamp('graded_at')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index('final_exam_id');
            $table->index('user_id');
            $table->index('status');
            
            // Unique: one submission per student per exam
            $table->unique(['final_exam_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_exam_submissions');
    }
};