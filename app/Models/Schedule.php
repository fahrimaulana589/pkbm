<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'rombel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'materi',
    ];

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class, 'rombel_id');
    }
}
