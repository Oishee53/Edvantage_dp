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
   Schema::create('video_progress', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('course_id');
    $table->unsignedBigInteger('resource_id'); // Use this instead of module_id
    $table->float('progress_percent')->default(0);
    $table->boolean('is_completed')->default(false);
    $table->timestamps();

    $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
    $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
    $table->unique(['user_id', 'course_id', 'resource_id']);
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_progress');
    }
};
