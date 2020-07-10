<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote_Pertanyaan extends Model
{
    protected $table = 'votepertanyaan';
    protected $fillable = [
        'user_id', 'pertanyaan_id', 'vote',
    ];
    public $timestamps = false;
}
