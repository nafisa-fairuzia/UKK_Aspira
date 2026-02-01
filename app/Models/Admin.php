<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = ['username', 'password', 'nama', 'profile_pic'];

    protected $hidden = ['password'];

    public function getProfilePicUrlAttribute()
    {
        if ($this->profile_pic) {
            return asset('storage/' . $this->profile_pic);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama ?? $this->username) . '&background=0ea5e9&color=fff';
    }
}
