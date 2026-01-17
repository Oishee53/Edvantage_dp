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
        Schema::create('discussion_forums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('resources')->onDelete('cascade'); // References resources table
            $table->string('title');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['course_id', 'module_id']);
            $table->unique('module_id'); // Each resource/module has exactly one forum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_forums');
    }
};