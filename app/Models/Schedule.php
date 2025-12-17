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
        'tutor_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'materi',
    ];

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class, 'rombel_id');
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Get the teacher for this schedule (Specific Tutor or fallback to Class Group's Tutor)
     */
    public function getTeacherAttribute()
    {
        return $this->tutor ?? $this->classGroup->tutor;
    }
}
