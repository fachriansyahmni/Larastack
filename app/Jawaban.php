<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';
    protected $fillable = [
        'pertanyaan_id', 'user_id', 'jawaban',
    ];
}
