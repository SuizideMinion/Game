@extends('blank')

@section('styles')
    <style xmlns:x-slot="http://www.w3.org/1999/xlink">
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%; /* Damit der Footer nach unten rutscht */
        }

        .chat-window {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            background-color: #000000;
            text-align: left; /* Nachrichten linksbündig */
        }

        .chat-message {
            margin-bottom: 5px;
        }

        .chat-message.global {
            color: orange;
        }

        .chat-message.system {
            color: gold;
        }

        .chat-message.alliance {
            color: green;
        }

        .chat-message.private {
            color: purple;
        }

        .chat-message.sector {
            color: white;
        }

        .chat-message span {
            white-space: pre;
        }

        /* Chat-Footer-Styling */
        .chat-footer {
            background-color: #2a2a2a;
            padding: 5px; /* Leichte innere Polsterung */
            display: flex;
            align-items: center;
            border-top: 1px solid #444;
            gap: 5px; /* Abstand zwischen den Elementen */
            position: relative;
            bottom: 0; /* Footer wird unten fixiert */
        }

        .chat-footer select,
        .chat-footer input[type="text"],
        .chat-footer button {
            height: 20px; /* Gleiche Höhe für alle drei Elemente */
            font-size: 14px; /* Konsistente Schriftgröße */
            border: 1px solid #36c486; /* Helles Grün */
            border-radius: 4px;
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .chat-footer select {
            padding: 0 5px; /* Innere Polsterung verkleinert */
        }

        .chat-footer input[type="text"] {
            flex: 1; /* Textfeld füllt den verbleibenden Platz aus */
            padding: 0 10px; /* Weniger Innenabstand für kompaktes Design */
        }

        .chat-footer input[type="text"]:focus {
            outline: none;
            background-color: #2a2a2a;
        }

        .chat-footer button {
            padding: 0 10px; /* Weniger Polsterung */
            background-color: #36c486; /* Helles Grün für den Button */
            color: black; /* Kontrastierende Schriftfarbe */
            cursor: pointer;
        }

        .chat-footer button:hover {
            background-color: #2ea26d; /* Dunkleres Grün beim Hover */
        }

        /* Um sicherzustellen, dass der Footer ganz unten bleibt */
        /*body, html {*/
        /*    height: 100%;*/
        /*    margin: 0;*/
        /*    display: flex;*/
        /*    flex-direction: column;*/
        /*}*/

        .chat-container {
            height: 100%; /* Stellt sicher, dass der Container den vollen Platz ausfüllt */
        }
    </style>
@endsection

@section('contend')

    <x-gui>
        <x-slot:title>
            Chat
        </x-slot:title>

        <div class="chat-container">
            <!-- Chat-Window-Bereich -->
            <div class="chat-window" id="chat-window"></div>
        </div>

        <x-slot:footer>
            <div class="chat-footer">
                <!-- Dropdown für Chatwahl -->
                <select name="chat-id" id="chat-dropdown" onchange="switchChat()">
                    @foreach($chats as $chat)
                        <option value="{{ $chat->id }}">{{ $chat->name }}</option>
                    @endforeach
                </select>

                <!-- Eingabefeld mit Event bei Enter -->
                <input
                    type="text"
                    id="message-input"
                    placeholder="Ihre Nachricht..."
                    class="message-input"
                    onkeyup="handleEnterKey(event)"
                />

                <!-- Senden Button -->
                <button onclick="sendMessage()">Senden</button>
            </div>
        </x-slot:footer>
    </x-gui>

@endsection

@section('scripts')

    <script>
        // Absende-Funktion: Nachricht an den Server senden
        async function sendMessage() {
            const messageInput = document.getElementById('message-input');
            const chatDropdown = document.getElementById('chat-dropdown');
            const message = messageInput.value.trim();
            const chatId = chatDropdown.value; // Aktuelle `chat_id` aus dem Dropdown

            // Sicherheitsprüfung
            if (!message) {
                alert("Nachricht darf nicht leer sein!");
                return;
            }

            try {
                // Serveranfrage für das Senden der Nachricht
                const response = await fetch('/api/put/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        chat_id: chatId,
                        message: message
                    })
                });

                if (!response.ok) {
                    throw new Error("Fehler beim Senden der Nachricht");
                }

                // Eingabefeld leeren bei Erfolg
                messageInput.value = '';
            } catch (error) {
                console.error("Fehler beim Absenden der Nachricht:", error);
                alert("Ihre Nachricht konnte nicht gesendet werden.");
            }
        }

        // Dynamisch eingehende Nachrichten verarbeiten (Parent sendet Daten alle 5 Sekunden)
        function parseAndDisplayMessages(data) {
            const chatWindow = document.getElementById('chat-window');
            const scrollable = document.getElementById('scrollable');
            const chatDropdown = document.getElementById('chat-dropdown');
            const currentChatId = chatDropdown.value; // Aktiver Chat

            // Leere Fenster und verarbeite nur Nachrichten für den aktiven Chat
            chatWindow.innerHTML = '';
            const relevantMessages = data.messages.filter(msg => msg.chat_id == currentChatId);

            relevantMessages.forEach(message => {
                const chatType = determineChatType(message);
                const formattedMessage = formatMessage(message, chatType);
                chatWindow.innerHTML += formattedMessage;
            });

            // Automatisch nach unten scrollen

            scrollable.scrollTop = scrollable.scrollHeight;
        }

        // Nachrichtentyp bestimmen
        function determineChatType(message) {
            if (message.chat_id == 1) return 'global';  // Beispiel Nachrichtentyp (Global)
            if (message.allianz_id != null) return 'alliance';
            if (message.sektor_id != null) return 'sector';
            if (message.receiver_id != null) return 'private';
            return 'system';
        }

        // Nachricht formatieren für die Anzeige
        function formatMessage(message, chatType) {
            const dateTime = new Date(message.created_at).toLocaleString();
            const sender = message.sender_id === 13418 ? "Du" : `Player ${message.sender_id}`;
            return `
            <div class="chat-message ${chatType}" data-id="${message.id}">
                <span>[${dateTime}] ${sender}:</span> ${message.message}
            </div>
        `;
        }

        function handleEnterKey(event) {
            // Überprüfen, ob die "Enter"-Taste gedrückt wurde
            if (event.key === 'Enter') {
                sendMessage(); // Nachricht senden
            }
        }

        // Nachrichten vom Parent empfangen
        window.addEventListener('message', function (event) {
            const data = event.data;
            if (data && data.messages) {
                parseAndDisplayMessages(data); // Verarbeite nur relevante Daten
            }
        });
    </script>

@endsection
