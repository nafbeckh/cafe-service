<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_id', 'to_id', 'no_pesanan', 'title', 'message', 'is_read'
    ];

    public static function countNotif($id) {
        
        return Self::where(['to_id' => $id, 'is_read' => '0'])->count();
    }

    public function from()
    {
        return $this->belongsTo(User::class);
    }

    public function to()
    {
        return $this->belongsTo(User::class);
    }
}
