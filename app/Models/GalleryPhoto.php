<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryPhoto extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'gallery_id',
        'file_path',
        'caption',
        'urutan',
    ];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    protected static function booted(): void
    {
        static::updating(function (GalleryPhoto $photo) {
            if ($photo->isDirty('file_path')) {
                $originalPath = $photo->getOriginal('file_path');
                if ($originalPath) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($originalPath);
                }
            }
        });

        static::deleting(function (GalleryPhoto $photo) {
            if ($photo->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->file_path);
            }
        });
    }
}
