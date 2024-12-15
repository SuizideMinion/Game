<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeLogin extends Model
{
    public $timestamps = false;

    protected $table = 'de_login';

    public function deUserData()
    {
        return $this->hasOne(DeUserData::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
