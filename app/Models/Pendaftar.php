<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    /** @use HasFactory<\Database\Factories\PendaftarFactory> */
    use HasFactory;

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    protected $fillable = [
        'program_id',
        'name',
        'address',
        'birth_place',
        'birth_date',
        'email',
        'phone',
        'status',
        'code',
    ];
}
