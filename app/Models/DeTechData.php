<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeTechData extends Model
{
    public $timestamps = false;

    public $table = 'de_tech_data';

    public function getUserTechs()
    {
        return $this->hasMany(DeUserTech::class, 'tech_id', 'tech_id')
        ->where('user_id', session()->get('ums_user_id'));
    }
}
