<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_internals', function (Blueprint $table) {
            $table->id('id_event_internal');
            $table->bigInteger('ormawa_id')->unsigned();
            $table->char('nama_event', 100);
            $table->bigInteger('kategori_id')->unsigned();
            $table->bigInteger('tipe_peserta_id')->unsigned();
            $table->char('maks_participant');
            $table->char('role', 20);
            $table->date('tgl_buka');
            $table->date('tgl_tutup');
            $table->text('deskripsi');
            $table->text('ketentuan')->nullable();
            $table->string('poster_image', 255);
            $table->string('banner_image', 255);
            $table->char('status', 100);
            $table->timestamps();

            $table->foreign('ormawa_id')->references('id_ormawa')->on('ormawas')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id_kategori')->on('kategori_events')->onDelete('cascade');
            $table->foreign('tipe_peserta_id')->references('id_tipe_peserta')->on('tipe_pesertas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_internals');
    }
}
