<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJawabanIdToVotejawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votejawaban', function (Blueprint $table) {
            $table->bigInteger('jawaban_id')->unsigned()->nullable();
            $table->foreign('jawaban_id')->references('id')->on('jawaban')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votejawaban', function (Blueprint $table) {
            $table->dropForeign(['jawaban_id']);
            $table->dropColumn('jawaban_id');
        });
    }
}
