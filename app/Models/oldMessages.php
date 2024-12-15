<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Messages extends Model
{
    protected $fillable = [
        'chats_id',
        'glob_id',
        'message',
    ];

    protected $connection = 'account';

    public function chat()
    {
        return $this->belongsTo(Chats::class);
    }
}


/*
 *
 *
 * -- Tabelle: chats erstellen
CREATE TABLE chats (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL, -- z.B. Allianz-Name, Sektor-ID, Global
    type VARCHAR(255) NOT NULL, -- global, private, sektor, allianz
    created_at TIMESTAMP NULL DEFAULT NULL, -- Timestamps automatisch mit NULL-Standardwert
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabelle: messages erstellen
CREATE TABLE messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    chat_id BIGINT UNSIGNED NOT NULL, -- Verweis auf die Chats-Tabelle
    glob_id BIGINT NOT NULL,
    message TEXT NOT NULL, -- Nachricht
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (chat_id) REFERENCES chats(id) ON DELETE CASCADE -- Löscht Nachrichten, wenn Chat gelöscht wird
);
 *
 *
 *
 *
 */
