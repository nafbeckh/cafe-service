<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_cafe', 'alamat', 'diskon', 'per_pesanan', 'path_logo'
    ];
}
