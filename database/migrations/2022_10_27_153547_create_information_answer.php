<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('information_id')->unsigned();
            $table->date('date_upload');
            $table->date('date_answer')->nullable();
            $table->text('file');
            $table->smallInteger('status')->default(0)->comment('0: menunggu 6: tolak 9: setuju');
            $table->text('description')->nullable();
            $table->bigInteger('author_upload')->unsigned();
            $table->bigInteger('author_answer')->unsigned();
            $table->timestamps();
            $table->foreign('information_id')->references('id')->on('information');
            $table->foreign('author_upload')->references('id')->on('users');
            $table->foreign('author_answer')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information_answers');
    }
}
