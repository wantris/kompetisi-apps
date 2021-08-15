<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapanEventEksternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapan_event_eksternals', function (Blueprint $table) {
            $table->id('id_tahapan_event_eksternal');
            $table->bigInteger('event_eksternal_id')->unsigned();
            $table->char('nama_tahapan', 100);
            $table->timestamps();

            $table->foreign('event_eksternal_id')->references('id_event_eksternal')->on('event_eksternals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tahapan_event_eksternals');
    }
}
