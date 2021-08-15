<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapanEventInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapan_event_internals', function (Blueprint $table) {
            $table->id('id_tahapan_event_internal');
            $table->bigInteger('event_internal_id')->unsigned();
            $table->char('nama_tahapan', 100);
            $table->timestamps();

            $table->foreign('event_internal_id')->references('id_event_internal')->on('event_internals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tahapan_event_internals');
    }
}
