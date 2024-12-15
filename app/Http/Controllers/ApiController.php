<?php

namespace App\Http\Controllers;

use App\Models\DeUserNews;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{
    public function put(Request $request, $id) {
        if ( $id == 'hideNews' ) return response()->json(['success', DeUserNews::where('user_id', auth()->id())->where('seen', 0)->update(['seen' => 1])]);

        if ( $id == 'chat') {
            // Validierung der Eingabedaten
            $validated = $request->validate([
                'chat_id' => 'required|integer', // ID des Chats
                'message' => 'required|string|max:1000', // Nachrichtentext
            ]);

            $last = Message::where('message', $request->message)
                ->where('sender_id', auth()->id())
                ->where('chat_id', $request->chat_id)
                ->where('created_at', '>=', Carbon::now()->subMinutes(2)) // Nur Nachrichten innerhalb der letzten 2 Minuten
                ->first();
            if( $last ) return response()->json(['Duplex Reply']);

            // Nachricht speichern
            $message = Message::create([
                'chat_id' => $validated['chat_id'],
                'sender_id' => auth()->id(), // Aktueller eingeloggter Benutzer
                'message' => BBCodeParser($validated['message']),
                'glob_id' => 0,
                'sektor_id' => auth()->user()->deUserData->sector,
                'allianz_id' => auth()->user()->deUserData->ally_id,
                'server' => 'wtf',
                'created_at' => now(),
            ]);

            // Antwort zurückgeben
            return response()->json([
                'id' => $message->id,
                'chat_id' => $message->chat_id,
                'sender_id' => $message->sender_id,
                'message' => BBCodeParser($message->message),
                'created_at' => $message->created_at,
            ]);
        }
    }

    public function getUser()
    {
        $user = User::where('id', auth()->id())
            ->with([
                'deUserData' => function ($query) {
                    $query->select('spielername', 'restyp01', 'restyp02', 'restyp03', 'restyp04', 'restyp05', 'credits', 'user_id', 'sector'); // user_id wird gebraucht für die Beziehung
                }
            ])
            ->first();
        $i = 0;

        foreach ($user->userNews as $value) {
            $i++;
            $n = $value->typ;

            switch ($n) {
                case 8:
                    if ($n == 8) $n = 3;
                    $werte = explode(";", $value->text);
                    $tronic = $werte[0];

                    $nachrichten[$i] = trimTime($value->time) .': '. __('tronic.'. $werte[1], ['tronic' => $tronic]);

                    break;
//            switch ($n) {
                case 50:
//                    $allenachrichten .= '<tr>';
//                    $allenachrichten .= '<td>' . $hrstr . '<br><img src="' . $ums_gpfad . 'g/' . $ums_rasse . '_e' . $n . '.gif" border="0" align="left" hspace="20"><br><b> ' . $time . '</b></td>';
//                    $allenachrichten .= '</tr>';
//                    $allenachrichten .= '<tr>';
//                    $allenachrichten .= '<td>' . showkampfberichtV0($row["text"], $ums_rasse, $ums_spielername, $sector, $system, $schiffspunkte) . '</td>';
//                    $allenachrichten .= '</tr>';
                    break;
                case 57:

                    $nachrichten[$i] = trimTime($value->time) .': '. $this->processBattleReport($value->text);
//                    $allenachrichten .= '<tr>';
//                    $allenachrichten .= '<td>' . $hrstr . '<br><img src="' . $ums_gpfad . 'g/' . $ums_rasse . '_e50.gif" border="0" align="left" hspace="20"><br><b> ' . $time . '</b></td>';
//                    $allenachrichten .= '</tr>';
//                    $allenachrichten .= '<tr>';
//                    $allenachrichten .= '<td>' . showkampfberichtV1($row["text"], $ums_rasse, $ums_spielername, $sector, $system, $schiffspunkte) . '</td>';
//                    $allenachrichten .= '</tr>';
                    break;
                case 70: //Battleground
//                    $allenachrichten .= '<tr style="text-align: left;">';
//                    $allenachrichten .= '<td>' . $hrstr . '<br><img src="' . $ums_gpfad . 'g/' . $ums_rasse . '_e50.gif" border="0" align="left" hspace="20"><br><b> ' . $time . '</b></td>';
//                    $allenachrichten .= '</tr>';
//                    $allenachrichten .= '<tr style="text-align: left;">';
//                    $allenachrichten .= '<td>' . showkampfberichtBG($row["text"]) . '</td>';
//                    $allenachrichten .= '</tr>';
                    break;
                default:
                    $nachrichten[$i] = trimTime($value->time) .': '. $value->text;
//                    //sektorkampfsymbol setzen, wenn n�tigt
//                    if ($n == 56) $n = 50;
//                    $allenachrichten .= '<tr>';
//                    $allenachrichten .= '<td>' . $hrstr . '<br><img src="' . $ums_gpfad . 'g/' . $ums_rasse . '_e' . $n . '.gif" border="0" align="left" hspace="20"><br><b> ' . $time . '</b></td>';
//                    $allenachrichten .= '</tr>';
//                    $allenachrichten .= '<tr>';
//                    $allenachrichten .= '<td>' . $row["text"] . '<br><br></td>';
//                    $allenachrichten .= '</tr>';
//                    break;
            }
        }
        $user->nachrichten = ($nachrichten ?? []);
        $user->newNews = $user->userNewNews->count();

        // hole HF Nachrichten
        $i = 0;
//        foreach($user->userHf as $hf) {
//            $i++;
//            $userHf[$i] = ($hf->gelesen == 0 ? '<b>':''). trimTime($hf->time) .' -> '. $hf->fromnic .': '. Str::limit(BBCodeParser($hf->text, all: true, nReplace: true), 100, ' ... Mehr lesen') . ($hf->gelesen == 0 ? '</b>':'');
//        }
////        dd($user->userHF);
//        $user->user_hf_new = array_reverse($userHf);
//        $user->hf_count = $user->userNewHF->count();
//
//        $user->user_hf = '';
//        $user->user_new_h_f = '';

        //CHAT!
        $messages = Message::where('sender_id', getID())
            ->orWhere('receiver_id', getID())
            ->orWhere('chat_id', '1')
            ->orWhere('chat_id', '99')
            ->orWhere('chat_id', '2') // aber den sektor dazu auslesen
            ->orWhere('chat_id', '3') // aber die allianz dazu auslesen
            ->orderBy('created_at', 'ASC')
            ->get();

// Speichern der Nachrichten
        $user->messages = $messages;

// IDs extrahieren und speichern
        $user->messageIds = $messages->pluck('id')->toArray();

        unset($user->userNews);
        return response()->json($user);
    }

    private function isSerialized($value)
    {
        if (!is_string($value) || trim($value) === '') {
            return false;
        }

        return @unserialize($value) !== false || $value === 'b:0;';
    }

    private function processBattleReport($serializedString) {
        // Deserialisieren des Strings
        $data = @unserialize($serializedString);

        // Überprüfen, ob der String erfolgreich deserialisiert wurde
        if ($data === false) {
            return "Ungültiger serialisierter String oder Fehler beim Unserialisieren.";
        }

        // Überprüfen, ob die notwendigen Schlüssel vorhanden sind
        if (isset($data['daten']['atterliste']) && isset($data['daten']['colstolen'])) {
//            dump($data['daten']['colstolen']);
            $atterliste = $data['daten']['atterliste']; // Angreifer
            $colstolen = $data['daten']['colstolen'];  // Gestohlene Kolonien

            // Ausgabe formatieren
            if ($colstolen <= 0)
                return "Dich hat {$atterliste} angegriffen und keine Kolektoren wurden gestohlen.";
            else
                return "Dich hat {$atterliste} angegriffen und {$colstolen} Kolektoren wurden gestohlen.";
        }

        return "Die benötigten Daten (atterliste oder colstolen) sind nicht vorhanden.";
    }
}
