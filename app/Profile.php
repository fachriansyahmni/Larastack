<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "profile";
    protected $fillable = [
        'user_id', 'nama_lengkap', 'bio', 'reputation'
    ];
    public $timestamps = false;

    public function User()
    {
        $this->hasMany('App\User');
    }
}
