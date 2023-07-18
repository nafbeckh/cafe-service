<?php

use Illuminate\Database\Migrations\Migration;

class LapPesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW lap_pesanans AS
                    SELECT pesanans.created_at AS tgl_pesanan, no_pesanan, users.nama AS waiter,
                    (SELECT SUM(jumlah) FROM pesanan_details
                    WHERE pesanan_details.no_pesanan = pesanans.no_pesanan) AS total_item,
                    (SELECT SUM(jumlah * harga) FROM pesanan_details
                    LEFT JOIN menus ON menus.id = pesanan_details.menu_id
                    WHERE pesanan_details.no_pesanan = pesanans.no_pesanan) AS total_harga
                    FROM pesanans
                    LEFT JOIN users ON users.id = pesanans.waiter_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW lap_pesanans");
    }
}
