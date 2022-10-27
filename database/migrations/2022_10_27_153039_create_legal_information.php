<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('information_id')->unsigned();
            $table->text('assignment');
            $table->text('ad_art');
            $table->timestamps();
            $table->foreign('information_id')->references('id')->on('information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_information');
    }
}
