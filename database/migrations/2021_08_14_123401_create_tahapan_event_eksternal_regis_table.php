<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapanEventEksternalRegisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapan_event_eksternal_regis', function (Blueprint $table) {
            $table->id('id_tahapan_event_regis');
            $table->bigInteger('tahapan_event_eksternal_id')->unsigned();
            $table->bigInteger('event_eksternal_regis_id')->unsigned();
            $table->timestamps();

            $table->foreign('tahapan_event_eksternal_id')->references('id_tahapan_event_eksternal')->on('tahapan_event_eksternals')->onDelete('cascade');
            $table->foreign('event_eksternal_regis_id')->references('id_event_eksternal_registration')->on('event_eksternal_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tahapan_event_eksternal_regis');
    }
}
