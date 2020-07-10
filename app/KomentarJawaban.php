<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarJawaban extends Model
{
    protected $table = 'komentar_jawaban';
    protected $fillable = [
        'jawaban_id', 'user_id', 'komentar',
    ];
}
