<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';
    protected $with = ['kategori', 'siswa'];
    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'ket',
        'gambar',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y, H:i');
    }

    public function getFormattedCreatedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    public function getFormattedCreatedTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke siswa yang membuat aspirasi
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    // Relasi ke tanggapan/aspirasi dari admin
    public function aspirasi()
    {
        return $this->hasOne(Aspirasi::class, 'id_input_aspirasi', 'id_pelaporan');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'Menunggu');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'Dibatalkan');
    }

    public function scopeByNis($query, $nis)
    {
        return $query->where('nis', $nis);
    }

    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('id_kategori', $kategoriId);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
