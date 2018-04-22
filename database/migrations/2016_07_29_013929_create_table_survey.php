<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->string('id_survey')->primary();
            $table->string('nama_survey');
            $table->string('tgl_mulai');
            $table->string('tgl_selesai');
            $table->integer('status');
            $table->string('tahun');
            $table->dateTime('tgl_create');
            $table->dateTime('tgl_update');
            $table->string('user_create');
            $table->string('user_update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('survey');
    }
}
