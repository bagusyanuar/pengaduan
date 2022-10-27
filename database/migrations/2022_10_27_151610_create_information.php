<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id');
            $table->date('date');
            $table->string('card_id');
            $table->string('name');
            $table->text('address');
            $table->string('job');
            $table->string('phone', 25);
            $table->string('email');
            $table->text('information');
            $table->text('purpose');
            $table->string('source');
            $table->smallInteger('type');
            $table->smallInteger('status');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information');
    }
}
