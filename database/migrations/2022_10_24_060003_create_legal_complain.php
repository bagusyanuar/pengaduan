<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalComplain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_complains', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('complain_id')->unsigned();
            $table->text('assignment');
            $table->text('ad_art');
            $table->timestamps();
            $table->foreign('complain_id')->references('id')->on('complains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_complains');
    }
}
