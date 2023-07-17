<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
  
    protected $primaryKey = 'no_pesanan';
    public $incrementing = false;

    protected $fillable = [
        'no_pesanan', 'meja_id', 'waiter_id', 'status'
    ];

    public static function generateNoPesanan()
    {
        $date = date('dmy');
        $lastPesanan = Self::select('no_pesanan')->where('no_pesanan', 'LIKE', 'NP'.$date.'%')->orderBy('no_pesanan', 'desc')->first();
        $urut = $lastPesanan ? substr($lastPesanan->no_pesanan, 8) + 1 : 1;
        $noPesanan = 'NP' . $date . sprintf('%04d', $urut);

        return $noPesanan;
    }

    public function pesanan_detail()
    {
        return $this->hasMany(Pesanan_detail::class, 'no_pesanan');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }
}
