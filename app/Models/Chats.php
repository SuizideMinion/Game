<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    protected $connection = 'account';

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }
}
