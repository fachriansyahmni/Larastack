<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarPertanyaan extends Model
{
    protected $table = 'komentar_pertanyaan';
    protected $fillable = [
        'pertanyaan_id', 'user_id', 'isi',
    ];
}
