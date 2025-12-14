<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class InfoPpdb extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'penulis_id'];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
