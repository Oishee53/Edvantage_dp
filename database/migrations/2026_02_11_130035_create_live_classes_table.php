<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
           $table->string('course_id');

            $table->date('live_date');
            $table->time('live_time');
            $table->string('meet_link');
            $table->timestamps();

            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('live_classes');
    }
};
