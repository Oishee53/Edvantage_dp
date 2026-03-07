<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Stores uploaded source documents
        Schema::create('notebook_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // student who uploaded
            $table->string('title');
            $table->string('file_name');
            $table->string('file_path');
            $table->enum('file_type', ['pdf', 'txt', 'docx']);
            $table->unsignedInteger('chunk_count')->default(0);
            $table->enum('status', ['processing', 'ready', 'failed'])->default('processing');
            $table->timestamps();
        });

        // Stores text chunks + their vector embeddings as JSON
        Schema::create('notebook_chunks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('notebook_documents')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->mediumText('content');           // raw text chunk
            $table->longText('embedding');           // JSON array of floats from Gemini
            $table->unsignedInteger('chunk_index');  // order within document
            $table->timestamps();
        });

        // Stores conversation history per student per course
        Schema::create('notebook_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('question');
            $table->longText('answer');
            $table->json('source_chunks')->nullable(); // which chunk IDs were used
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notebook_conversations');
        Schema::dropIfExists('notebook_chunks');
        Schema::dropIfExists('notebook_documents');
    }
};