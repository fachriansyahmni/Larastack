<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "profile";
    protected $fillable = [
        'user_id', 'nama_lengkap', 'gender', 'tanggal_lahir', 'photo', 'reputation'
    ];
    public $timestamps = false;

    public function getPhoto()
    {
        if (!$this->photo) {
            return asset('img/profile/nophoto.jpg');
        }else{
        return asset('img/profile/'.$this->photo);
        }
    }

    public function User()
    {
        $this->hasMany('App\User');
    }
}
