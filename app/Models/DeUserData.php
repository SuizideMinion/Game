<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeUserData extends Model
{
    public $timestamps = false;

    public $table = 'de_user_data';

    public function userNews()
    {
        return $this->hasMany(DeUserNews::class, 'user_id', 'user_id');
    }
}
