<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_menu', 'kategori_id', 'harga', 'foto'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function pesanan_detail()
    {
        return $this->belongsTo(Pesanan_detail::class);
    }
}
