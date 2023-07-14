<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PesananDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan_details', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesanan', 12);
            $table->unsignedBigInteger('menu_id');
            $table->integer('jumlah');
            $table->foreign('no_pesanan')->references('no_pesanan')->on('pesanans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('menu_id')->references('id')->on('menus')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('pesanan_details');
    }
}
