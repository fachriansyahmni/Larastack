<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comment';
    protected $fillable = [
        'pertanyaan_id', 'jawaban_id', 'isi',
    ];
}
