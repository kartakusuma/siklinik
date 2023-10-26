<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekamMedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('perawat_id');
            $table->unsignedBigInteger('dokter_id');
            $table->unsignedBigInteger('ruang_id');
            $table->date('tanggal');
            $table->time('jam');
            $table->text('objektif');
            $table->text('subjektif');
            $table->string('kesadaran');
            $table->string('tingkat_nyeri');
            $table->text('riwayat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekam_medis');
    }
}
