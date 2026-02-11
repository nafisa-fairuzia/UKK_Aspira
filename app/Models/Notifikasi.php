<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $with = ['pengaduan'];
    protected $fillable = [
        'judul',
        'pesan',
        'url',
        'tipe',
        'id_pengaduan',
        'dibaca',
    ];
    protected $casts = [
        'dibaca' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_pengaduan', 'id_pelaporan');
    }

    public function scopeUnread($query)
    {
        return $query->where('dibaca', false);
    }

    public function scopeRead($query)
    {
        return $query->where('dibaca', true);
    }

    public function scopeForAdmin($query)
    {
        return $query->where('tipe', 'admin');
    }

    public function scopeForSiswa($query)
    {
        return $query->where('tipe', 'siswa');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeCountUnread($query)
    {
        return $query->where('dibaca', false)->count();
    }
}
