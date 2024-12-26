<?php

use App\Models\User;

// Das User-Modell verwenden
use Illuminate\Support\Facades\Hash;

function getID()
{
    return session()->get('ums_user_id');
}


function getRace($int = false)
{
    if ($int) {
        if(session()->get('race') == 1) return 'b';
        if(session()->get('race') == 2) return 'l';
        if(session()->get('race') == 3) return 'r';
        if(session()->get('race') == 4) return 'g';
        if(session()->get('race') == 5) return 'p';
    }

    return session()->get('race');
}


use Jenssegers\Agent\Agent;

if (!function_exists('agent')) {
    function agent()
    {
        return new Agent();
    }
}


if (!function_exists('countLangEntries')) {
    /**
     * Zählt die Anzahl der Einträge in einem Sprach-Array.
     *
     * @param string $key Der Sprachschlüssel (z. B. "wt.kolliemsg").
     * @return int|null Gibt die Anzahl der Einträge zurück, oder null, falls der Schlüssel ungültig ist.
     */
    function countLangEntries(string $key): ?int
    {
        // Ruft die Sprachdatei mit dem angegebenen Schlüssel ab
        $langArray = __('' . $key);

        // Überprüfen, ob die Rückgabe ein Array ist
        if (is_array($langArray)) {
            return count($langArray); // Gibt die Anzahl der Einträge zurück
        }

        return null; // Gibt null zurück, wenn es kein Array ist
    }
}

function getGreekSymbol($number)
{
    // Zeichentabelle der griechischen Zeichen
    $greekSymbols = [
        0 => '∞', // Erhabener
        1 => 'Α',  // Alpha
        2 => 'Β',  // Beta
        3 => 'Γ',  // Gamma
        4 => 'Δ',  // Delta
        5 => 'Ε',  // Epsilon
        6 => 'Ζ',  // Zeta
        7 => 'Η',  // Eta
        8 => 'Θ',  // Theta
        9 => 'Ι',  // Iota
        10 => 'Κ', // Kappa
        11 => 'Λ', // Lambda
        12 => 'Μ', // Mu
        13 => 'Ν', // Nu
        14 => 'Ξ', // Xi
        15 => 'Ο', // Omicron
        16 => 'Π', // Pi
        17 => 'Ρ', // Rho
        18 => 'Σ', // Sigma
        19 => 'Τ', // Tau
        20 => 'Υ', // Upsilon
        21 => 'Φ', // Phi
        22 => 'Χ', // Chi
        23 => 'Ψ', // Psi
        24 => 'Ω'  // Omega
    ];

    // Überprüfen, ob die Zahl in der Tabelle existiert
    if (array_key_exists($number, $greekSymbols)) {
        return $greekSymbols[$number];
    } else {
        return "Kein gültiges griechisches Zeichen für $number verfügbar.";
    }
}

function sendDiscordMessage($message, $name = 'DE', $webhookUrl = 'https://discord.com/api/webhooks/1314350972524433428/hJAebp9osduzpQS0771wFxBGaY1WWu-WwfauhmRdtGxxRleS2DTVmGhXTAwXlblqCilU')
{
    $data = [
        "content" => $message,
        "username" => $name // Optional: Setze den Namen des Bots
    ];

    $jsonData = json_encode($data);

    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    if ($response === FALSE) {
        die('Fehler beim Senden der Nachricht: ' . curl_error($ch));
    }

    curl_close($ch);
    return $response;
}

function loginOrRegisterLegacyUser($ums_user_id, $ums_nic): string
{
    // Suchen nach einem Benutzer in der Laravel-Datenbank basierend auf der user_id
    $user = User::where('id', $ums_user_id)->first();

    if ($user) {
        // Der Benutzer existiert bereits -> Einloggen
        $response = Http::get(route('login-user'), [
            'pass' => $user->password
        ]);
        session()->put('ums_user_id', $ums_user_id); // Legen Sie Ihre Session-Variable fest
        request()->session()->regenerate();
//        dd(auth()->user());
        return $ums_nic . ': erfolgreich eingeloggt';
    } else {
        $userPw = Hash::make('default_password');

        // Der Benutzer existiert nicht -> Registrieren und einloggen
        $user = User::create([
            'id' => $ums_user_id, // Speichern der Legacy user_id für den Bezug
            'name' => $ums_nic, // Der Nickname des Benutzers aus Legacy
            'email' => $ums_nic . '@legacy.de', // Erstellen Sie eine Dummy-E-Mail-Adresse
            'password' => $userPw, // Standardpasswort (dies kann später geändert werden)
        ]);
        $response = Http::get(route('login-user'), [
            'pass' => $user->password
        ]);

//        \Auth::login($user, true);
        request()->session()->regenerate();
        session()->put('ums_user_id', $ums_user_id); // Legen Sie Ihre Session-Variable fest

        return $ums_nic . ': registriert und eingeloggt';
    }
}

function detectDevice()
{
    $agent = request()->header('User-Agent');

    $isMobile = preg_match('/Mobile|Android|iP(hone|od|ad)|webOS|BlackBerry|IEMobile|Kindle/i', $agent);

    if ($isMobile) {
        return 'Das Gerät ist ein mobiles Gerät.';
    } else {
        return 'Das Gerät ist ein Desktop/PC.';
    }
}

function trimTime(string $input, string $format = 'Y-m-d H:i:s'): string|array
{
    // Prüfen, ob es ein Unix-Timestamp ist (10-stellig)
    if (ctype_digit($input) && strlen($input) === 10 && ($timestamp = intval($input)) !== false) {
        // Unix-Timestamp in ein benutzerdefiniertes Format konvertieren
        return date($format, $timestamp);
    }

    // Prüfen, ob es ein 14-stelliges Zahlenformat ist (z.B. 20241218205920)
    if (ctype_digit($input) && strlen($input) === 14) {
        // Die ersten 4 Ziffern extrahieren (Jahr)
        $year = substr($input, 0, 4);

        // Den Rest in 2-stellige Abschnitte aufteilen
        $parts = str_split(substr($input, 4), 2);

        // Datum und Uhrzeit zusammenbauen
        $date = $year . '-' . $parts[0] . '-' . $parts[1];
        $time = $parts[2] . ':' . $parts[3] . ':' . $parts[4];

        // Das gewünschte Ausgabeformat generieren
        if (str_contains($format, ' ')) {
            // Kombination aus Datum und Zeit
            return $date . ' ' . $time;
        } elseif (str_contains($format, ':')) {
            // Nur Zeit zurückgeben (z. B. H:i:s)
            return $time;
        } else {
            // Nur Datum zurückgeben (z. B. Y-m-d)
            return $date;
        }
    }

    // Falls das Format nicht korrekt ist, Fehler zurückgeben
    return 'Ungültiger Eingabestring';
}

function shortenNumber($number, $precision = 2)
{
    if ($number < 1000) {
        // Keine Kürzung nötig
        return $number;
    }

    // Kürzel-Liste erweitert bis zu Dezillionen und mehr
    $units = [
        '',      // 10^0
        'K',     // Tausend (10^3)
        'M',     // Millionen (10^6)
        'B',     // Milliarden (10^9)
        'T',     // Billionen (10^12)
        'Q',     // Quadrillionen (10^15)
        'Qi',    // Quintillionen (10^18)
        'Sx',    // Sextillionen (10^21)
        'Sp',    // Septillionen (10^24)
        'Oc',    // Oktillionen (10^27)
        'No',    // Nonillionen (10^30)
        'Dc',    // Dezillionen (10^33)
        'Ud',    // Undezillionen (10^36)
        'Dd',    // Duodezillionen (10^39)
        'Td',    // Tredezillionen (10^42)
        'Qd',    // Quattuordezillionen (10^45)
        'Qid',   // Quindecillionen (10^48)
        'Sxd',   // Sexdezillionen (10^51)
        'Spd',   // Septendezillionen (10^54)
    ];

    // Berechnung des Größenordnung-Index
    $unitIndex = (int)floor(log($number, 1000)); // Logarithmus zur Basis 1000 berechnen

    if ($unitIndex >= count($units)) {
        // Falls der Index die unterstützte Größenordnung überschreitet, gib die Zahl in voller Länge aus.
        return number_format($number, $precision);
    }

    // Zahl in die entsprechende Einheit umwandeln
    $shortNumber = $number / pow(1000, $unitIndex);

    // Abrunden auf die gewünschte Präzision
    $factor = pow(10, $precision); // Faktor für die Rundung
    $shortNumber = floor($shortNumber * $factor) / $factor; // Wert präzisionsgenau abrunden

    // Ausgabe der abgerundeten Zahl zusammen mit der Einheit
    return $shortNumber . $units[$unitIndex];
}

function getDefaultVariable($key)
{

    //datenbankdefinitionen
    $sv_database_de = "de_server_rde";
    $sv_database_sou = "sou_server_main";

    //server auf dem die grafiken liegen
    $sv_image_server = '';
    $sv_image_server_list[] = 'https://www.die-ewigen.com/degp3v2/';
    //$sv_image_server_list[]='http://dieewigen.com/degp3/';

    //gewinnpunktzahl
    $sv_winscore = 66666;

    //zu haltende ticks
    $sv_benticks = 2880;

    //maximalzahl der spieler
    $sv_maxuser = 10000;

    //maximalzahl der sektoren
    $sv_maxsector = 17;

    //anzahl der spieler pro sektor
    $sv_maxsystem = 600;

    //l�schzeit bei inaktivit�t in tagen
    $sv_inactiv_deldays = 7;

    //l�schzeit bei nicht erfolgter accountaktivierung
    $sv_not_activated_deldays = 2;

    //l�schzeit der hf
    $sv_hf_deldays = 14;

    //l�schzeit der nachrichten
    $sv_nachrichten_deldays = 7;

    //maximalanzahl der efta-bewegungspunkte
    $sv_max_efta_bew_punkte = 5000;

    //angriffsgrenze in hundertsteln
    $sv_attgrenze = 0.40;

    //angriffsgrenzenbonus durch die whg in hundertsteln
    $sv_attgrenze_whg_bonus = 0.0;

    //sektorangriffsmalus in hundertsteln
    $sv_sector_attmalus = 0.20;

    //maximale angriffsgrenze f�r kollektoren
    $sv_max_col_attgrenze = 0.35;

    //minimale angriffsgrenze f�r kollektoren
    $sv_min_col_attgrenze = 0.20;

    //sektoren anzeigen bis sektor
    $sv_show_maxsector = 1999;

    //ab welchem sektor sind die npc-accounts
    $sv_npc_minsector = 1000;

    //bis wohin gehen die npc-sectoren
    $sv_npc_maxsector = 1199;

    //anzahl der sektoren die vorne nicht von spielern belegt werden
    $sv_free_startsectors = 1;

    //bei wieviel prozent leute beim rausvoten verschwinden
    $sv_voteoutgrenze = 40;

    //maximal anzahl von sektorumz�gen
    $sv_max_secmoves = 0;

    //minimumanzahl beim reggen eines privatsektors
    $sv_min_user_per_regsector = 4;

    //maximumanzahl beim reggen eines privatsektors
    $sv_max_user_per_regsector = 6;

    //ab wo werden die regsektoren eingebaut
    $sv_min_regsec = 501;

    //server tag, z.b. nde sde usw.
    $sv_server_tag = 'RDE';

    $sv_server_name = 'Centaurus A';

    //bonus vom planetaren schild auf die hp der t�rme, wert in %
    $sv_ps_bonus = 10;

    //recyclotronertrag mit und ohne whg in prozent
    $sv_recyclotron_bonus = 15;
    $sv_recyclotron_bonus_whg = 30;

    //server id
    $sv_servid = 11;

    //anzahl von rassen, schiffen/turmtypen
    $sv_anz_schiffe = 8;
    $sv_anz_tuerme = 5;
    $sv_anz_rassen = 5;

    //Max Anzahl dir HFN's  im Archiv | Eintr�ge in der Buddy/Ignoreliste
    $sv_hf_buddie = 10;
    $sv_hf_ignore = 10;
    $sv_hf_archiv = 10;

    //s.o. im bezug auf premium accounts!
    $sv_hf_buddie_p = 50;
    $sv_hf_ignore_p = 50;
    $sv_hf_archiv_p = 50;

    //klaubare kollies
    $sv_kollie_klaurate = 0.15;

    //energieertrag der kollektoren mit und ohne pa
    $sv_kollieertrag = 100;
    $sv_kollieertrag_pa = 105;

    //planetarer grundertrag, mit und ohne gilde
    $sv_plan_grundertrag = array(1000, 125, 75, 50);
    $sv_plan_grundertrag_whg = array(4000, 500, 200, 100);

    //wahrscheinlichkeit, dass tronic verteilt wird pro tick
    $sv_globalw_tronic = 15;

    //wahrscheinlichkeit, dass Zuf�lle verteilt werden pro tick
    $sv_globalw_zufall = 15;

    //Anzahl der zu spielenden Ticks bevor die Zufallsereignisse beginnen
    $sv_global_start_zufall = 2000;

    //Mod-Ids f�rs SK forum
    $mods = array(1);

    //lebenszeit der session in sekunden
    $sv_session_lifetime = 3600;

    //zeit f�r den aktivit�tsbonus in sekunden
    $sv_activetime = 720;

    //maximalzahl f�r diplomatieartefakte
    $sv_max_dartefakt = 3;

    //preise f�r den schwarzmarkt
    $sv_sm_preisliste = array(50, 8, 10, 300, 175, 20, 5);

    //max palenium
    $sv_max_palenium = 100;

    //id f�r das pcs
    $sv_pcs_id = 12;

    //das siegel von basranur: nach x ticks starten, ticklaufzeit, maxprozent
    $sv_siegel1 = array(480, 4800, 0.03);

    //serversprache
    $sv_server_lang = 1;

    //punkte f�r kriegsartefakte
    $sv_kartefakt_exp_atter = 5000;
    $sv_kartefakt_exp_deffer = 4500;

    //maximalzahl der credits, die man durch aktivit�t erhalten kann
    $sv_credits_max_collect = 1000000;

    //zeitspanne zwischen den sektorvotes
    $sv_sector_votetime_lock = 3360;

    //bis zu wievielen kollektoren hin kann man npc-accounts angreifen
    $sv_npcatt_col_grenze = 400;

    //efta-kollektor-malus
    $sv_efta_col_malus = 5;

    //planetare schilderweiterung: min./standard/max.
    $sv_planetshieldext = array(0, 0.05, 1);

    //max. reclyctronbonus nach sektorverteilung
    $sv_recyclotron_sector_bonus = 40;

    //maximal m�glicher recyclotronbetrag
    $sv_recyclotron_max = 80;

    //kleinster recyclotronwert
    $sv_recyclotron_min = 15;

    $sv_ewige_runde = 0;

    if ($sv_ewige_runde == 1) {
        //energieertrag durch Z�llner
        $sv_kriegsartefaktertrag = 200;
        //energieertrag durch kriegsartefakte
        $sv_zoellnerertrag = array(0.0125 * 2, 0.00625 * 2, 0.00417 * 2, 0.003125 * 2);
    } else {
        $sv_kriegsartefaktertrag = 100;
        $sv_zoellnerertrag = array(0.0125, 0.00625, 0.00417, 0.003125);
    }

    //energieertrag durch eftaartefakte
    $sv_eftaartefaktertrag = 10;

    //wieviel man von dem kopfgeld bekommt
    $sv_bounty_rate = 0.10;

    //ist es ein bezahlserver
    $sv_payserver = 0;

    //ist efta in de integriert
    $sv_efta_in_de = 1;

    //ist sou in de integriert
    $sv_sou_in_de = 1;

    //flags zur deaktivierung einzelner spielelemente
    $sv_deactivate_efta = 0;
    $sv_deactivate_sou = 0;
    $sv_deactivate_trade = 0;
    $sv_deactivate_sec1moveout = 0;
    $sv_deactivate_kiatt = 1;

    //creditgewinne
    //punkte
    $sv_credit_win[0][0] = 75;
    $sv_credit_win[0][1] = 25;
    $sv_credit_win[0][2] = 10;
    //executorpunkte
    $sv_credit_win[1][0] = 75;
    $sv_credit_win[1][1] = 25;
    $sv_credit_win[1][2] = 10;
    //kopfgeldj?ger
    $sv_credit_win[2][0] = 0;
    $sv_credit_win[2][1] = 0;
    $sv_credit_win[2][2] = 0;
    //eftapunkte
    $sv_credit_win[3][0] = 0;
    $sv_credit_win[3][1] = 0;
    $sv_credit_win[3][2] = 0;
    //erhabener
    $sv_credit_win[4][0] = 200;

    //autoreset auf dem server?
    $sv_auto_reset = 1;

    //V-Systeme deaktivieren
    $sv_deactivate_vsystems = 1;


    //Tick-Einstellungen
    $GLOBALS['wts'][0] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][1] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][2] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][3] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][4] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][5] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][6] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][7] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][8] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][9] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][10] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][11] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][12] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][13] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][14] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][15] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][16] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][17] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][18] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][19] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][20] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][21] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][22] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    $GLOBALS['wts'][23] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);

    $GLOBALS['kts'][0] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][1] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][2] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][3] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][4] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][5] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][6] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][7] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][8] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][9] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][10] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][11] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][12] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][13] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][14] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][15] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][16] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][17] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][18] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][19] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][20] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][21] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][22] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);
    $GLOBALS['kts'][23] = array(0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56);


    // Kombiniere alle Variablen in ein assoziatives Array
    $allVariables = [
        'sv_database_de' => $sv_database_de,
        'sv_database_sou' => $sv_database_sou,
        'sv_image_server' => $sv_image_server,
        'sv_image_server_list' => $sv_image_server_list,
        'sv_winscore' => $sv_winscore,
        'sv_benticks' => $sv_benticks,
        'sv_maxuser' => $sv_maxuser,
        'sv_maxsector' => $sv_maxsector,
        'sv_maxsystem' => $sv_maxsystem,
        'sv_inactiv_deldays' => $sv_inactiv_deldays,
        'sv_not_activated_deldays' => $sv_not_activated_deldays,
        'sv_hf_deldays' => $sv_hf_deldays,
        'sv_nachrichten_deldays' => $sv_nachrichten_deldays,
        'sv_max_efta_bew_punkte' => $sv_max_efta_bew_punkte,
        'sv_attgrenze' => $sv_attgrenze,
        'sv_attgrenze_whg_bonus' => $sv_attgrenze_whg_bonus,
        'sv_sector_attmalus' => $sv_sector_attmalus,
        'sv_max_col_attgrenze' => $sv_max_col_attgrenze,
        'sv_min_col_attgrenze' => $sv_min_col_attgrenze,
        'sv_show_maxsector' => $sv_show_maxsector,
        'sv_npc_minsector' => $sv_npc_minsector,
        'sv_npc_maxsector' => $sv_npc_maxsector,
        'sv_free_startsectors' => $sv_free_startsectors,
        'sv_voteoutgrenze' => $sv_voteoutgrenze,
        'sv_max_secmoves' => $sv_max_secmoves,
        'sv_min_user_per_regsector' => $sv_min_user_per_regsector,
        'sv_max_user_per_regsector' => $sv_max_user_per_regsector,
        'sv_min_regsec' => $sv_min_regsec,
        'sv_server_tag' => $sv_server_tag,
        'sv_server_name' => $sv_server_name,
        'sv_ps_bonus' => $sv_ps_bonus,
        'sv_recyclotron_bonus' => $sv_recyclotron_bonus,
        'sv_recyclotron_bonus_whg' => $sv_recyclotron_bonus_whg,
        'sv_servid' => $sv_servid,
        'sv_anz_schiffe' => $sv_anz_schiffe,
        'sv_anz_tuerme' => $sv_anz_tuerme,
        'sv_anz_rassen' => $sv_anz_rassen,
        'sv_hf_buddie' => $sv_hf_buddie,
        'sv_hf_ignore' => $sv_hf_ignore,
        'sv_hf_archiv' => $sv_hf_archiv,
        'sv_hf_buddie_p' => $sv_hf_buddie_p,
        'sv_hf_ignore_p' => $sv_hf_ignore_p,
        'sv_hf_archiv_p' => $sv_hf_archiv_p,
        'sv_kollie_klaurate' => $sv_kollie_klaurate,
        'sv_kollieertrag' => $sv_kollieertrag,
        'sv_kollieertrag_pa' => $sv_kollieertrag_pa,
        'sv_plan_grundertrag' => $sv_plan_grundertrag,
        'sv_plan_grundertrag_whg' => $sv_plan_grundertrag_whg,
        'sv_globalw_tronic' => $sv_globalw_tronic,
        'sv_globalw_zufall' => $sv_globalw_zufall,
        'sv_global_start_zufall' => $sv_global_start_zufall,
        'mods' => $mods,
        'sv_session_lifetime' => $sv_session_lifetime,
        'sv_activetime' => $sv_activetime,
        'sv_max_dartefakt' => $sv_max_dartefakt,
        'sv_sm_preisliste' => $sv_sm_preisliste,
        'sv_max_palenium' => $sv_max_palenium,
        'sv_pcs_id' => $sv_pcs_id,
        'sv_siegel1' => $sv_siegel1,
        'sv_server_lang' => $sv_server_lang,
        'sv_kartefakt_exp_atter' => $sv_kartefakt_exp_atter,
        'sv_kartefakt_exp_deffer' => $sv_kartefakt_exp_deffer,
        'sv_credits_max_collect' => $sv_credits_max_collect,
        'sv_sector_votetime_lock' => $sv_sector_votetime_lock,
        'sv_npcatt_col_grenze' => $sv_npcatt_col_grenze,
        'sv_efta_col_malus' => $sv_efta_col_malus,
        'sv_planetshieldext' => $sv_planetshieldext,
        'sv_recyclotron_sector_bonus' => $sv_recyclotron_sector_bonus,
        'sv_recyclotron_max' => $sv_recyclotron_max,
        'sv_recyclotron_min' => $sv_recyclotron_min,
        'sv_ewige_runde' => $sv_ewige_runde,
        'sv_kriegsartefaktertrag' => $sv_kriegsartefaktertrag,
        'sv_zoellnerertrag' => $sv_zoellnerertrag,
        'sv_eftaartefaktertrag' => $sv_eftaartefaktertrag,
        'sv_bounty_rate' => $sv_bounty_rate,
        'sv_payserver' => $sv_payserver,
        'sv_efta_in_de' => $sv_efta_in_de,
        'sv_sou_in_de' => $sv_sou_in_de,
        'sv_deactivate_efta' => $sv_deactivate_efta,
        'sv_deactivate_sou' => $sv_deactivate_sou,
        'sv_deactivate_trade' => $sv_deactivate_trade,
        'sv_deactivate_sec1moveout' => $sv_deactivate_sec1moveout,
        'sv_deactivate_kiatt' => $sv_deactivate_kiatt,
        'sv_credit_win' => $sv_credit_win,
        'sv_auto_reset' => $sv_auto_reset,
        'sv_deactivate_vsystems' => $sv_deactivate_vsystems,
        'sv_ang' => 1, //neue DE-Version
        'sv_log_player_actions' => 1, //Spieleraktionen mitloggen?
        'tech_build_time_faktor' => 0.066,
        'sv_show_ally_secstatus' => 240,
        'sv_max_alien_col' => 400,
        'sv_max_alien_col_typ' => 0,
        'sv_hide_fp_in_secstatus' => 0, //verstecke FP in Sekstatus
        'sv_debug' => 0, //verstecke FP in Sekstatus
        'sv_comserver' => 0, //verstecke FP in Sekstatus
        'sv_comserver_roundtyp' => 0, //verstecke FP in Sekstatus
        'sv_hardcore' => 0, //verstecke FP in Sekstatus
        'sv_hardcore_need_wins' => 5, //verstecke FP in Sekstatus
        'wts' => array_fill(0, 24, range(0, 59)),  // Zeiger für jeden Tick von 0-59
        'kts' => array_fill(0, 24, range(0, 56, 4)),  // Tick-Intervalle
    ];

    // Gib den Schlüssel aus, wenn er existiert
    return $allVariables[$key] ?? null;
}
