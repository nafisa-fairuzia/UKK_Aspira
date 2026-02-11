<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{

    protected $table = 'aspirasi';
    protected $primaryKey = 'id_aspirasi';
    protected $with = ['kategori', 'inputAspirasi'];
    protected $fillable = [
        'status',
        'id_kategori',
        'feedback',
        'id_input_aspirasi',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function inputAspirasi()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_input_aspirasi', 'id_pelaporan');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'Menunggu');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'Ditolak');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
