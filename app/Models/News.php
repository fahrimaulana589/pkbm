<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'kategori_id',
        'judul',
        'slug',
        'konten',
        'gambar',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'kategori_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(NewsTag::class, 'news_news_tag', 'news_id', 'news_tag_id');
    }

    protected static function booted(): void
    {
        static::updating(function (News $news) {
            if ($news->isDirty('gambar')) {
                $originalGambar = $news->getOriginal('gambar');
                if ($originalGambar) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($originalGambar);
                }
            }
        });

        static::deleting(function (News $news) {
            if ($news->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($news->gambar);
            }
        });
    }
}
