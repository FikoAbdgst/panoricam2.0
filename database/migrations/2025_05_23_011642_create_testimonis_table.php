<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonisTable extends Migration
{
    public function up()
    {
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->integer('rating'); // 1-5 stars
            $table->string('emoji')->nullable();
            $table->string('name')->nullable();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('frame_id')->nullable();
            $table->timestamps();

            $table->foreign('frame_id')->references('id')->on('frames')->onDelete('set null');
            $table->index(['created_at', 'rating']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonis');
    }
}
