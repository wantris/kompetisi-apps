<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->char('username')->unique();
            $table->string('password', 255);
            $table->boolean('is_mahasiswa');
            $table->boolean('is_participant');
            $table->boolean('is_wadir3');
            $table->boolean('is_pembina');
            $table->boolean('is_dosen');
            $table->char('nim', 20)->nullable();
            $table->char('nidn', 20)->nullable();
            $table->bigInteger('pembina_id')->unsigned()->nullable();
            $table->bigInteger('wadir3_id')->unsigned()->nullable();
            $table->bigInteger('participant_id')->unsigned()->nullable();
            $table->string('email', 100)->nullable();
            $table->char('phone', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('photo', 255)->nullable();
            $table->timestamps();

            $table->foreign('pembina_id')->references('id_pembina')->on('pembinas')->onDelete('cascade');
            $table->foreign('wadir3_id')->references('id_wadir3')->on('wadir3s')->onDelete('cascade');
            $table->foreign('participant_id')->references('id_participant')->on('participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penggunas');
    }
}
