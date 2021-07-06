<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembinas', function (Blueprint $table) {
            $table->id('id_pembina');
            $table->char('nidn', 100);
            $table->bigInteger('ormawa_id')->unsigned();
            $table->boolean('status');
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
        Schema::dropIfExists('pembinas');
    }
}
