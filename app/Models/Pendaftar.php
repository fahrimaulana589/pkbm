<?php

namespace App\Models;

use App\Enums\PendaftarStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Pendaftar extends Model
{
    /** @use HasFactory<\Database\Factories\PendaftarFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'extra_attributes' => SchemalessAttributes::class,
        'status' => PendaftarStatus::class,
        'birth_date' => 'date',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function ppdb(): BelongsTo
    {
        return $this->belongsTo(Ppdb::class);
    }

    public function scopeWithExtraAttributes(Builder $query): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public static function generateUniqueCode(): string
    {
        do {
            $code = (string) mt_rand(100000, 999999);
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
