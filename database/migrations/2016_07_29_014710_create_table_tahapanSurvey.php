<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTahapanSurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapansurvey', function (Blueprint $table) {
            $table->integer('id_tahapan');
            $table->string('id_survey');
            $table->primary(['id_tahapan', 'id_survey']);
            $table->string('nama_tahapan');
            $table->string('tgl_mulai');
            $table->string('tgl_selesai');
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
        Schema::drop('tahapansurvey');
    }
}

