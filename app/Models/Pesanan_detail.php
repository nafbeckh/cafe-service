<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_pesanan', 'menu_id', 'jumlah'
    ];

    public static function getTotal($noPpesanan) {
        $total = 0;
        $det = Self::with('menu')->where(['no_pesanan' => $noPpesanan])->get();

        foreach($det as $item) {
            $total = $total + ($item->jumlah * $item->menu->harga);
        }

        return $total;
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'no_pesanan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
