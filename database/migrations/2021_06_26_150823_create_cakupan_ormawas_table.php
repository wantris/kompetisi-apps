<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCakupanOrmawasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cakupan_ormawas', function (Blueprint $table) {
            $table->id('id_cakupan_ormawa');
            $table->bigInteger('ormawa_id')->unsigned()->nullable();
            $table->string('role', 100)->nullable();
            $table->timestamps();

            $table->foreign('ormawa_id')->references('id_ormawa')->on('ormawas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cakupan_ormawas');
    }
}
