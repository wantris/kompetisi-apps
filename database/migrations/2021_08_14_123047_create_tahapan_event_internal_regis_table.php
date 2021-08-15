<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapanEventInternalRegisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapan_event_internal_regis', function (Blueprint $table) {
            $table->id('id_tahapan_event_regis');
            $table->bigInteger('tahapan_event_internal_id')->unsigned();
            $table->bigInteger('event_internal_regis_id')->unsigned();
            $table->timestamps();

            $table->foreign('tahapan_event_internal_id')->references('id_tahapan_event_internal')->on('tahapan_event_internals')->onDelete('cascade');
            $table->foreign('event_internal_regis_id')->references('id_event_internal_registration')->on('event_internal_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tahapan_event_internal_regis');
    }
}
