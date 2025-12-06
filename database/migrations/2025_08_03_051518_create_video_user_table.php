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


    Schema::create('video_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('video_id')->constrained()->onDelete('cascade');
        $table->integer('progress')->default(0); // percent watched (0-100)
        $table->timestamp('completed_at')->nullable(); // when video was fully watched
        $table->timestamps(); // created_at and updated_at
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_user');
    }
};
