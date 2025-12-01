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
}
