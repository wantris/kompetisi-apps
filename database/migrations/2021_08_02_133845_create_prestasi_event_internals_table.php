<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiEventInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestasi_event_internals', function (Blueprint $table) {
            $table->id('id_prestasi_event_internal');
            $table->bigInteger('event_internal_registration_id')->unsigned();
            $table->char('posisi', 5);
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('event_internal_registration_id')->references('id_event_internal_registration')->on('event_internal_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestasi_event_internals');
    }
}
