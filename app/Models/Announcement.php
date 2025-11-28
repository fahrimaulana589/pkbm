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
}