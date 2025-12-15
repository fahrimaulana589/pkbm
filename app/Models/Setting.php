<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'email_server',
        'email_port',
        'email_username',
        'email_password',
        'ppdb_foto',
        'ppdb_sambutan',
        'ppdb_alur',
    ];
}
