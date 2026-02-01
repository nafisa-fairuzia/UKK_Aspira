<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'judul',
        'pesan',
        'url',
        'tipe',
        'id_pengaduan',
        'dibaca',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_pengaduan', 'id_pelaporan');
    }

    public function scopeUnread($query)
    {
        return $query->where('dibaca', false);
    }

    public function scopeForAdmin($query)
    {
        return $query->where('tipe', 'admin');
    }

    public function scopeForSiswa($query)
    {
        return $query->where('tipe', 'siswa');
    }
}
