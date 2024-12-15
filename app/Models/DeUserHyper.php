<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeUserHyper extends Model
{
    public $timestamps = false;

    protected $table = 'de_user_hyper';

    protected $fillable = [
        'fromsec',
        'fromsys',
        'fromnic',
        'time',
        'betreff',
        'text',
        'archiv',
        'sender',
        'gelesen',
        'empfaenger',
        'absender',
    ];

    public function empfaenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'empfaenger');
    }

    public function absender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'absender');
    }
}
