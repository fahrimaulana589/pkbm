<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'pendidikan_terakhir',
        'keahlian',
        'status',
    ];

    public function classGroups(): HasMany
    {
        return $this->hasMany(ClassGroup::class);
    }
}
