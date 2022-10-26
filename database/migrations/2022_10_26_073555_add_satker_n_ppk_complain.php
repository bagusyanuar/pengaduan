<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatkerNPpkComplain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->smallInteger('target')->after('status')->default(0)->comment('0:satker, 1:ppk');
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
        Schema::table('complains', function (Blueprint $table) {
            $table->dropForeign('complains_satker_id_foreign');
            $table->dropForeign('complains_ppk_id_foreign');
            $table->dropColumn('satker_id');
            $table->dropColumn('ppk_id');
        });
    }
}
