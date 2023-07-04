<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meja_id');
            $table->unsignedBigInteger('waiter_id');
            $table->enum('status', ['Belum Dikonfirmasi', 'Dikonfirmasi', 'Selesai'])->default('Belum Dikonfirmasi');
            $table->foreign('meja_id')->references('id')->on('mejas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('waiter_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('pesanans');
    }
}
