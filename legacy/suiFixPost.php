<?php

// Maximale Skriptlaufzeit auf 5 Minuten setzen
//set_time_limit(300);

function updatePhpFiles($directory) {
    // Durchsucht rekursiv das angegebene Verzeichnis
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        // Nur PHP-Dateien bearbeiten
        if ($file->isFile() && $file->getExtension() === 'php') {
            echo "Verarbeite Datei: {$file->getFilename()}...<br>";
            $filePath = $file->getRealPath();
            $contents = file_get_contents($filePath);
            $matchesCount = 0;

            // Finde alle Vorkommen von $_POST['key'] und ersetze sie durch getPostValue('key')
            $updatedContents = preg_replace_callback(
                "/\$_POST\s*\[\s*['\"]([^'\"]+)['\"]\s*\]/",
                function ($matches) use (&$matchesCount) {
                    $matchesCount++;
                    echo "Match gefunden: {$matches[0]} wird zu getPostValue('{$matches[1]}') umgewandelt.<br>";
                    return "getPostValue('{$matches[1]}')";
                },
                $contents
            );
            dump($contents, $updatedContents);
            // Anzahl der Ersetzungen ausgeben
            echo "Ersetzungen in dieser Datei: {$matchesCount}<br>";

            // Speichere die Änderungen, wenn der Inhalt aktualisiert wurde
            if ($updatedContents !== $contents) {
                file_put_contents($filePath, $updatedContents);
                echo "Aktualisiert: {$filePath}<br>";
            }
        }
    }
}

// Verzeichnis setzen, das durchlaufen werden soll
$directory = base_path('legacy/'); // Verzeichnis auf das gewünscht ändern

// Alle Vorkommen von $_POST ändern
updatePhpFiles($directory);

echo "Fertig!";
