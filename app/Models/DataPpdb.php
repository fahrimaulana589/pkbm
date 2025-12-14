<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPpdb extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppdb_id',
        'nama',
        'jenis',
        'status',
        'default',
    ];

    protected $casts = [
        'jenis' => \App\Enums\DataPpdbType::class,
    ];


    public function ppdb()
    {
        return $this->belongsTo(Ppdb::class);
    }
}
