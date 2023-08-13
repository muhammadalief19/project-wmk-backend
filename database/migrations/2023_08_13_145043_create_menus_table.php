<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mitra')->constrained('mitra')->onDelete('restrict')->onUpdate('restrict');
            $table->string('kode_menu')->uniqid();
            $table->string('nama_menu');
            $table->bigInteger('harga');
            $table->string('deskripsi');
            $table->enum('status', ['tersedia', 'kosong']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
};
