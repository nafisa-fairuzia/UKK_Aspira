<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = true;
    protected $fillable = ['ket_kategori'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function inputAspirasi()
    {
        return $this->hasMany(InputAspirasi::class, 'id_kategori', 'id_kategori');
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'id_kategori', 'id_kategori');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('ket_kategori', 'like', '%' . $keyword . '%');
    }

    public function scopeOrderByNama($query)
    {
        return $query->orderBy('ket_kategori', 'asc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
