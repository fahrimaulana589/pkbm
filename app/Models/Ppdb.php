<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    /** @use HasFactory<\Database\Factories\PpdbFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'tahun',
        'status',
        'start_date',
        'end_date',
    ];
    public function dataPpdbs()
    {
        return $this->hasMany(DataPpdb::class);
    }
}
