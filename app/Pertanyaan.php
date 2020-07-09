<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';
    protected $fillable = [
        'penanya_id', 'judul', 'tag', 'isi'
    ];

    public function User()
    {
        return $this->belongsTo('App\User', 'penanya_id', 'id');
    }
}
