<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('nip_user')->unique();
            $table->integer('level_user');
            $table->string('avatar');
            $table->rememberToken();
            $table->dateTime('tgl_create');
            $table->dateTime('tgl_update');
        });

        $now = new DateTime;
        DB::table('users')->insert(['name'=>'Andy Eka Saputra', 'username'=>'aneksa', 'nip_user'=>'123123', 'level_user'=>'1', 'avatar'=>'anonymous.jpg', 'tgl_create'=>$now, 'tgl_update'=>$now]);
        DB::table('users')->insert(['name'=>'Alvian', 'username'=>'alvian', 'nip_user'=>'111111', 'level_user'=>'1', 'avatar'=>'anonymous.jpg', 'tgl_create'=>$now, 'tgl_update'=>$now]);
        DB::table('users')->insert(['name'=>'Hengky', 'username'=>'hengky', 'nip_User'=>'222222', 'level_user'=>'2', 'avatar'=>'anonysmous.jpg', 'tgl_create'=>$now, 'tgl_update'=>$now]);
        DB::table('users')->insert(['name'=>'Kamal', 'username'=>'kamal', 'nip_user'=>'333333', 'level_user'=>'2', 'avatar'=>'anonymous.jpg', 'tgl_create'=>$now, 'tgl_update'=>$now]);
        DB::table('users')->insert(['name'=>'Eka', 'username'=>'dyetra', 'nip_user'=>'444444', 'level_user'=>'2', 'avatar'=>'anonymous.jpg', 'tgl_create'=>$now, 'tgl_update'=>$now]);
        DB::table('users')->insert(['name'=>'Supriadi', 'username'=>'Supriadi', 'nip_User'=>'555555', 'level_user'=>'2', 'avatar'=>'anonymous.jpg', 'tgl_create'=>$now, 'tgl_update'=>$now]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
