<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'kategori_id');
    }
}
