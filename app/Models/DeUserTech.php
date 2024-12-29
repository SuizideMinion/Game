<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeUserTech extends Model
{
    public $timestamps = false;

    protected $table = 'de_user_techs';
    protected $primaryKey = 'tech_id'; // Setzt user_id als Primärschlüssel
    protected $keyType = 'int'; // Typ des Primärschlüssels (z. B. integer)

    protected $fillable = ['user_id', 'tech_id', 'time_finished'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(DeUserData::class, 'user_id');
    }

    public function tech(): BelongsTo
    {
        return $this->belongsTo(DeTechData::class, 'tech_id');
    }

    public function deTechData()
    {
        // Beziehung zu DeTech, falls es über tech_id verknüpft ist
        return $this->belongsTo(DeTechData::class, 'tech_id', 'tech_id');
    }

    public function techData()
    {
        return $this->belongsTo(DeTechData::class, 'tech_id', 'tech_id');
    }
}
