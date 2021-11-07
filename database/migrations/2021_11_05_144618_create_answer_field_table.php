<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_field', function (Blueprint $table) {
            $table->foreignId('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->foreignId('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->foreignId('question_id')->references('id')->on('questions');
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_field');
    }
}
