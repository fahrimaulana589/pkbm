<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'kategori',
        'nama_program',
        'deskripsi',
        'durasi',
        'status',
    ];

    // Placeholder relationships - to be implemented fully when related models exist
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function classGroups(): HasMany
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
