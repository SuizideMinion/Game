<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Alle Chats anzeigen
    public function index()
    {
        return view('chat.index', ['chats' => Chats::all()]);
    }

    // Nachrichten für einen Chat abrufen
    public function show(Chats $chat)
    {
        return $chat->messages()->with('user')->get();
    }

    // Nachricht senden
    public function sendMessage(Request $request, Chats $chat)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $chat->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return $message->load('user');
    }
}
