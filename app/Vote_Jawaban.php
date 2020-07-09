<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote_Jawaban extends Model
{
    protected $table = 'votejawaban';
    protected $fillable = [
        'user_id', 'jawaban_id', 'vote',
    ];
    public $timestamps = false;
}
