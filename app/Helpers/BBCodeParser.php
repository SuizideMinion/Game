<?php

function parseSmileys($text): array|string
{
    $smileys = [
        ':laugh:' => '😁',      // Äquivalent zu ':D'
        ':sad:' => '😢',         // Äquivalent zu ':('
        ':smile:' => '😊',       // Äquivalent zu ':)'
        ':wink:' => '😉',        // Zwinkern
        ':tongue:' => '😜',      // Zunge heraus
        ':surprised:' => '😮',   // Überraschung
        ':cool:' => '😎',        // Cool
        ':confused:' => '😕',    // Verwirrt
        ':shocked:' => '😱',     // Schockiert
        ':love:' => '❤️',       // Herz
        ':kiss:' => '😘',        // Kuss
        ':angry:' => '😠',       // Wütend
        ':neutral:' => '😐',     // Neutral
        ':devil:' => '😈',       // Teufel
        ':cry:' => '😭',         // Weinen
        ':laughing:' => '😂',    // Lachen
        ':disappointed:' => '😞', // Enttäuscht
        ':sleepy:' => '😴',      // Schläfrig
        ':wink2:' => '😉',        // Zwinkern
        ':nerd:' => '😎',        // Nerd
        ':oops:' => '😳',        // Oh je
        ':tired:' => '😩',       // Müde
        ':party:' => '🥳',       // Feier
        ':smirk:' => '😏',       // Schmunzeln
        ':sweat:' => '😅',       // Schweiß

        // Zusätzliche Smileys
        ':kiss_blow:' => '😘',   // Luftkuss
        ':scream:' => '😱',      // Geschockt
        ':mask:' => '😷',        // Maske tragen
        ':thinking:' => '🤔',    // Nachdenklich
        ':clown:' => '🤡',       // Clown
        ':heart_eyes:' => '😍',  // Herzaugen
        ':star_struck:' => '🤩', // Sternenblick
        ':yawning:' => '🥱',     // Gähnen
        ':rofl:' => '🤣',        // Auf dem Boden rollen vor Lachen
        ':hugs:' => '🤗',        // Umarmung
        ':vomit:' => '🤮',       // Übergeben
        ':money:' => '🤑',       // Geldgesicht
        ':robot:' => '🤖',       // Roboter
        ':ghost:' => '👻',       // Geist
        ':fire:' => '🔥',        // Feuer
        ':sparkles:' => '✨',    // Funkeln
        ':muscle:' => '💪',      // Stark
        ':peace:' => '✌️',       // Frieden

        // Weitere zusätzliche Smileys
        ':happy:' => '😄',       // Glücklich
        ':blush:' => '☺️',       // Erröten
        ':sunglasses:' => '🕶️',  // Sonnenbrille
        ':hugging:' => '🤗',      // Umarmung
        ':frowning:' => '🙁',     // Unzufrieden
        ':pensive:' => '😔',     // Nachdenklich
        ':thinking2:' => '🤔',    // Nachdenklich
        ':facepalm:' => '🤦',     // Gesichts-Palm
        ':scream2:' => '😱',      // Schrei
        ':zany:' => '😜',        // Verrückt
        ':tada:' => '🎉',        // Konfetti
        ':coffee:' => '☕',      // Kaffee
        ':champagne:' => '🥂',   // Champagner
        ':thumbs_up:' => '👍',    // Daumen hoch
        ':thumbs_down:' => '👎',  // Daumen runter
        ':ok_hand:' => '👌',      // Okay-Handzeichen
        ':crying:' => '😢',      // Weinen
        ':angry2:' => '😠',       // Wütend
        ':blush2:' => '😊',       // Verlegen
        ':wink3:' => '😉',        // Zwinkern
        ':gift:' => '🎁',        // Geschenk
        ':sparkles2:' => '✨',    // Funkeln

        // ... Fügen Sie hier noch mehr Smileys hinzu ...
    ];

    return str_replace(array_keys($smileys), array_values($smileys), $text);
}


function BBCodeParser($text, $all = false, $nReplace = false): array|string
{
    if($all) $text = preg_replace('/\[[^\]]*\]/', '', $text);
    // Entferne alle < und > am Anfang des Textes
    $text = ltrim($text, "<>");
    $text = strip_tags($text);
    $text = handleFirstAndLastItalic($text);
    // Ersetze Zeilenumbrüche
    $text = $nReplace ? str_replace("\n", '', $text):nl2br($text);

    // Unterstütze Farb-Codes
    $text = preg_replace('/\[color=(-?[\w\d]+)\](.*?)\[\/color\]/is', '<span style="color:$1;">$2</span>', $text);

    // Unterstütze Fett-Schrift
    $text = preg_replace('/\[b](.*?)\[\/b\]/is', '<strong>$1</strong>', $text);

    // Unterstütze Fett und kursiv
    $text = preg_replace('/\[b\]([^\[]*?)(\[i](.*?)\[\/i\])?\[\/b\]/is', '<strong>$1$3</strong>', $text);

    // Unterstütze Kursivschrift
    $text = preg_replace('/\[i](.*?)\[\/i\]/is', '<em>$1</em>', $text);

    // Unterstütze Unterstrich
    $text = preg_replace('/\[u](.*?)\[\/u\]/is', '<u>$1</u>', $text);

    // Unterstütze durchgestrichenen Text
    $text = preg_replace('/\[s](.*?)\[\/s\]/is', '<del>$1</del>', $text);

    // Unterstütze Links
    $text = preg_replace('/\[url=(.*?)\](.*?)\[\/url\]/is', '<a href="$1">$2</a>', $text);
    $text = preg_replace('/\[url](.*?)\[\/url\]/is', '<a href="$1">$1</a>', $text);
    $text = preg_replace('/\[URL](.*?)\[\/URL\]/is', '<a href="$1">$1</a>', $text);

    // Unterstütze Bilder
    $text = preg_replace('/\[img](.*?)\[\/img\]/is', '<img src="$1" alt="" />', $text);

    // Unterstütze Listen (unordentliche Liste)
    $text = preg_replace('/\[list\](.*?)\[\/list\]/is', '<ul>$1</ul>', $text);
    $text = preg_replace('/\[listitem\](.*?)\[\/listitem\]/is', '<li>$1</li>', $text);

    // Unterstütze zentrierten Text
    $text = preg_replace('/\[center\](.*?)\[\/center\]/is', '<div style="text-align: center;">$1</div>', $text);

    // Unterstütze Kopfzeilen
    $text = preg_replace('/\[h1\](.*?)\[\/h1\]/is', '<h1>$1</h1>', $text);
    $text = preg_replace('/\[h2\](.*?)\[\/h2\]/is', '<h2>$1</h2>', $text);
    $text = preg_replace('/\[h3\](.*?)\[\/h3\]/is', '<h3>$1</h3>', $text);

    // Unterstütze Zitate mit Autor
    $text = preg_replace('/\[quote=([^]]+?)\](.*?)\[\/quote\]/is', '<blockquote><strong>$1:</strong> $2</blockquote>', $text);
    $text = preg_replace('/\[quote\](.*?)\[\/quote\]/is', '<blockquote>$1</blockquote>', $text);

    // Unterstütze Code-Blöcke
    $text = preg_replace('/\[code\](.*?)\[\/code\]/is', '<pre><code>$1</code></pre>', $text);

    // Unterstütze Spoiler
    $text = preg_replace('/\[spoiler\](.*?)\[\/spoiler\]/is', '<div class="spoiler"><button class="spoiler-button" style="background-color: limegreen; color: white; border: none;">Spoiler anzeigen</button><div class="spoiler-content" style="display:none;">$1</div></div>', $text);


    // Unterstütze horizontale Linien
    $text = preg_replace('/\[hr\]/is', '<hr />', $text);

    return parseSmileys($text);

}
function handleFirstAndLastItalic($text) {
    // Suche das erste [i] und das letzte [/i]
    if (preg_match('/\[i\](.*)\[\/i\]/is', $text, $matches)) {
        // Hole den gesamten Bereich zwischen dem ersten und letzten `[i]` und `[/i]`
        $content = $matches[1];

        // Entferne alle zusätzlichen [i] und [/i] innerhalb des Inhalts
        $cleanedContent = preg_replace('/\[\/?i\]/is', '', $content);

        // Setze den gesamten Bereich kursiv und ersetze im ursprünglichen Text
        $text = preg_replace('/\[i\].*\[\/i\]/is', '<em>' . $cleanedContent . '</em>', $text);
    }
    return $text;
}
