<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatkerPpk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppk', function (Blueprint $table) {
            $table->bigInteger('satker_id')->unsigned()->after('id');
            $table->foreign('satker_id')->references('id')->on('satker');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppk', function (Blueprint $table) {
            $table->dropForeign('ppk_satker_id_foreign');
            $table->dropColumn('satker_id');
        });
    }
}
