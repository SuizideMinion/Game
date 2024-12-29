<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeUserData extends Model
{
    public $timestamps = false;

    public $table = 'de_user_data';
    protected $connection = 'mysql'; // Name der anderen Datenbankverbindung
    protected $primaryKey = 'user_id'; // Setzt user_id als Primärschlüssel
    protected $keyType = 'int'; // Typ des Primärschlüssels (z. B. integer)

    public function userNews()
    {
        return $this->hasMany(DeUserNews::class, 'user_id', 'user_id');
    }
}
