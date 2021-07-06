<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrmawasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ormawas', function (Blueprint $table) {
            $table->id('id_ormawa');
            $table->string('nama_ormawa', 255);
            $table->char('nama_akronim', 100)->nullable();
            $table->char('username', 100)->unique();
            $table->string('password', 255);
            $table->char('email', 100)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('banner', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->char('website', 100)->nullable();
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
        Schema::dropIfExists('ormawas');
    }
}
