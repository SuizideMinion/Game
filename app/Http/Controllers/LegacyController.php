<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegacyController extends Controller
{
    public function handle(Request $request, $path = 'index.php')
    {
        // Berechne den vollständigen Pfad zur Legacy-Datei
        $legacyFilePath = base_path('legacy/' . $path);

        // Prüfe, ob die Datei existiert und im Legacy-Verzeichnis liegt
        if (!file_exists($legacyFilePath) || !str_starts_with(realpath($legacyFilePath), realpath(base_path('legacy')))) {
            abort(404, 'Die angeforderte Datei wurde nicht gefunden.');
        }

        // Führe die Legacy-Datei aus und sammle die Ausgabe
        ob_start();
        include_once $legacyFilePath;
        $content = ob_get_clean();

        // Gebe die Ausgabe zurück
        return response($content);
    }
}
