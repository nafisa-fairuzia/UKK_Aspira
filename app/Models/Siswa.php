<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $with = ['kelas'];
    protected $fillable = [
        'nis',
        'nama',
        'id_kelas',
        'profile_pic',
        'username',
        'password'
    ];
    protected $hidden = [
        'password'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('nama', 'like', '%' . $keyword . '%')
            ->orWhere('nis', 'like', '%' . $keyword . '%');
    }

    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('id_kelas', $kelasId);
    }

    public function scopeOrderByNama($query)
    {
        return $query->orderBy('nama', 'asc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
