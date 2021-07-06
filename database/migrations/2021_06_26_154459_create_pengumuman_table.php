<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id('id_pengumuman');
            $table->bigInteger('event_internal_id')->unsigned();
            $table->bigInteger('event_eksternal_id')->unsigned();
            $table->string('photo', 255)->nullable();
            $table->char('title', 100);
            $table->text('deskripsi');


            $table->timestamps();

            $table->foreign('event_internal_id')->references('id_event_internal')->on('event_internals')->onDelete('cascade');
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
        Schema::dropIfExists('pengumumen');
    }
}
