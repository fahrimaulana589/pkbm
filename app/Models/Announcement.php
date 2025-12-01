<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'announcements';

    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'kategori',
        'prioritas',
        'status',
        'lampiran_file',
        'thumbnail',
        'published_at',
        'start_date',
        'end_date',
        'penulis_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
        'kategori' => 'string',
        'prioritas' => 'string',
        'status' => 'string',
    ];

    /**
     * Get the user that owns the announcement.
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    protected static function booted(): void
    {
        static::updating(function (Announcement $announcement) {
            if ($announcement->isDirty('lampiran_file')) {
                $originalLampiran = $announcement->getOriginal('lampiran_file');
                if ($originalLampiran) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($originalLampiran);
                }
            }

            if ($announcement->isDirty('thumbnail')) {
                $originalThumbnail = $announcement->getOriginal('thumbnail');
                if ($originalThumbnail) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($originalThumbnail);
                }
            }
        });

        static::deleting(function (Announcement $announcement) {
            if ($announcement->lampiran_file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->lampiran_file);
            }
            if ($announcement->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->thumbnail);
            }
        });
    }
}