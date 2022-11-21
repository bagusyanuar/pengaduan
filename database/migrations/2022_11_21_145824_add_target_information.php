<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('information', function (Blueprint $table) {
            $table->text('information_source')->after('information');
            $table->smallInteger('target')->after('status')->nullable()->comment('0:satker, 1:ppk');
            $table->bigInteger('satker_id')->unsigned()->nullable()->after('target');
            $table->bigInteger('ppk_id')->unsigned()->nullable()->after('satker_id');
            $table->foreign('satker_id')->references('id')->on('satker');
            $table->foreign('ppk_id')->references('id')->on('ppk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('information', function (Blueprint $table) {
            $table->dropForeign('information_satker_id_foreign');
            $table->dropForeign('information_ppk_id_foreign');
            $table->dropColumn('information_source');
            $table->dropColumn('satker_id');
            $table->dropColumn('ppk_id');
            $table->dropColumn('target');
        });
    }
}
