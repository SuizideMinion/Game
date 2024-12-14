<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'planet_id', 'level'];

    protected $table = 'de_tech_data';

    public function planet()
    {
        return $this->belongsTo(Planet::class);
    }
}
