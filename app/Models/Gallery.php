<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('urutan');
    }

    protected static function booted(): void
    {
        static::deleting(function (Gallery $gallery) {
            // Delete all associated photos
            // The GalleryPhoto model's deleting event will handle the file deletion
            foreach ($gallery->photos as $photo) {
                $photo->delete();
            }
        });
    }
}
