<?php
namespace App\Services;

use App\Models\DeTechData;
use App\Models\DeUserData;
use App\Models\DeUserTech;

class BuildingService
{
    private $buildings;
    private $speedModifier; // Hinzugefügter Geschwindigkeitsmodifikator
    private mixed $user_id;

    public function __construct()
    {
        $this->speedModifier = getDefaultVariable('tech_build_time_faktor'); // Standardmäßig auf 1.0 gesetzt (keine Änderung)
        $this->loadBuildings();
        $this->user_id = auth()->id();
        $this->debug = false;
    }

    private function loadBuildings()
    {
        $this->buildings = json_decode(DeTechData::with('getUserTechs')->get(), true);
    }

    public function getBuildings()
    {
        // Lade alle Gebäude-Daten
        $buildings = DeTechData::with('getUserTechs')->get();

        // Lade Benutzer-Technologien einmal vorab
        $userTechIds = DeUserTech::where('user_id', $this->user_id)->pluck('tech_id')->toArray();

        // Lade alle laufenden Bauvorhaben des Nutzers vorab (mit Eloquent)
        $currentTime = time();
        $activeConstructions = DeUserTech::where('user_id', $this->user_id)
            ->where('time_finished', '>', $currentTime)
            ->pluck('tech_id')
            ->toArray(); // Nur die IDs der laufenden Bauvorhaben holen
        $userTechIds = array_diff($userTechIds, $activeConstructions);
        // Mappe die Gebäude und prüfe die Kriterien
        $this->buildings = $buildings->map(function ($building) use ($userTechIds, $activeConstructions) {
            $building = $building->toArray(); // In Array umwandeln
            $building['can_build_without_ressources'] = $this->canBuildWithoutRessourcen($building, $userTechIds, $activeConstructions); // Ohne Ressourcen prüfen
            return $building;
        })->toArray();

        // Gebe die Gebäude und deren Status als Antwort zurück
        return response()->json(['status' => 'success', 'buildings' => $this->buildings], 200);
    }

    private function canBuildWithoutRessourcen($building, $userTechIds, $activeConstructions)
    {
        $errors = [];

        // 1. Technologische Voraussetzungen prüfen
        if (!empty($building['tech_vor'])) {
            // IDs aus dem Feld 'tech_vor' extrahieren und das Präfix 'T' entfernen
            $requiredTechIds = explode(';', $building['tech_vor']);
            $requiredTechIds = array_map(function ($id) {
                return str_replace('T', '', $id); // Entferne das 'T' aus der ID
            }, $requiredTechIds);

            foreach ($requiredTechIds as $requiredTechId) {
                if (!in_array($requiredTechId, $userTechIds)) {
                    $errors[] = "Fehlende Technologie: {$requiredTechId}";
                }
            }
        }

        // 2. Prüfen, ob das Gebäude bereits gebaut wurde
        if (in_array($building['tech_id'], $activeConstructions)) { // 3. Prüfen, ob das Gebäude gerade gebaut wird
            //
        } elseif (in_array($building['tech_id'], $userTechIds)) {
            $errors[] = "Das Gebäude mit der ID {$building['tech_id']} wurde bereits gebaut.";
        }
//
//        // Debugging
//        if (!empty($errors)) {
//            \Log::info("Gebäude {$building['tech_id']} kann nicht gebaut werden: " . implode(', ', $errors));
//        }

        return empty($errors) ? true : $errors;
    }

    function dumpIt($wert)
    {
        if ($this->debug) {
            dd($wert);
        } else {
            return false;
        }
    }

    public function canBuild($buildingId)
    {
        $building = $this->getBuildingById($buildingId);
        if (!$building) {
            $this->dumpIt('Das Gebäude existiert nicht');
        }

        // Benutzer-Technologien vorab laden
        $userTechIds = DeUserTech::where('user_id', $this->user_id)
            ->where('time_finished', '<', time())
            ->pluck('tech_id')
            ->toArray();

        // Laufende Bauvorhaben des Nutzers vorab laden
        $currentTime = time();
        $activeConstructions = DeUserTech::where('user_id', $this->user_id)
            ->where('time_finished', '>', $currentTime)
            ->pluck('tech_id')
            ->toArray();

        // 1. Überprüfung ohne Ressourcen (via canBuildWithoutRessourcen)
        $canBuildWithoutResources = $this->canBuildWithoutRessourcen($building, $userTechIds, $activeConstructions);

        if ($canBuildWithoutResources !== true) {
            // Fehlermeldungen ausgeben, wenn Voraussetzungen nicht erfüllt sind
            $this->dumpIt($canBuildWithoutResources);
        }

        // 2. Ressourcenkosten überprüfen
        if (!empty($building['tech_build_cost'])) {
            $requiredCosts = explode(';', $building['tech_build_cost']);
            $userData = DeUserData::where('user_id', $this->user_id)->first();

            if (!$userData) {
                // Wenn keine Benutzerdaten vorhanden sind, kann er nicht bauen
                $this->dumpIt('Keine Benutzerdaten vorhanden');
            }

            foreach ($requiredCosts as $cost) {
                [$resourceKey, $requiredAmount] = explode('x', $cost);

                // Ressourcen-Key in DeUserData umwandeln (z.B. R1 -> restyp01)
                $userResourceField = 'restyp' . str_pad(substr($resourceKey, 1), 2, '0', STR_PAD_LEFT);

                if ($userData->$userResourceField < $requiredAmount) {
                    // Benutzer hat nicht genügend Ressourcen
                    $this->dumpIt('Benutzer hat nicht genügend Ressourcen');
                }
            }
        }

        // Wenn alle Prüfungen bestanden sind
        return true;
    }

    public function startBuild($buildingId)
    {
        // Prüfen, ob bereits ein Gebäude desselben Typs gebaut wird
//        dd(!isset($this->canBuildByType($buildingId)[0]));
        if (isset($this->canBuildByType($buildingId)[0])) {
            $this->dumpIt('Kein weiteres Gebäude dieses Typs kann gebaut werden'); // Kein weiteres Gebäude dieses Typs kann gebaut werden
            return false; // Bau nicht möglich, wenn ein Gebäude gebaut wird
        }

        // Prüfen, ob bereits ein anderes Gebäude (unabhängig vom Typ) im Bau ist
//        $currentlyBuilding = DeUserTech::where('user_id', $this->user_id)
//            ->where('time_finished', '>', time()) // Nur aktive Bauzeiten
//            ->first();
//
//        if ($currentlyBuilding) {
//            return false; // Bau nicht möglich, wenn ein Gebäude gebaut wird
//        }

        // Standard-Logik fortsetzen
        if ($this->canBuild($buildingId)) {
            $building = $this->getBuildingById($buildingId);
            $currentTime = time();

            // Bauzeit berechnen
            $modifiedBuildTime = (int) round($building['tech_build_time'] * $this->speedModifier);

            // Ressourcen abziehen
            if (!empty($building['tech_build_cost'])) {
                $requiredCosts = explode(';', $building['tech_build_cost']);
                $userData = DeUserData::where('user_id', $this->user_id)->first();

                if (!$userData) {
                    $this->dumpIt('Keine Ressourcendaten vorhanden'); //return false; // Keine Ressourcendaten vorhanden
                }

                foreach ($requiredCosts as $cost) {
                    [$resourceKey, $requiredAmount] = explode('x', $cost);

                    // Ressourcen-Feldname transformieren (z. B. R1 -> restyp01)
                    $userResourceField = 'restyp' . str_pad(substr($resourceKey, 1), 2, '0', STR_PAD_LEFT);

                    // Ressourcen abziehen
                    $userData->$userResourceField -= $requiredAmount;

                    if ($userData->$userResourceField < 0) {
                        $this->dumpIt('Nicht genug Ressourcen'); //return false; // Keine Ressourcendaten vorhanden
                    }
                }

                $userData->save(); // Geänderte Ressourcen speichern
            }

            // Bau starten
            DeUserTech::updateOrCreate(
                [
                    'user_id' => $this->user_id,
                    'tech_id' => $buildingId,
                ],
                [
                    'time_finished' => $currentTime + $modifiedBuildTime, // Fertigstellungszeit setzen
                ]
            );

            return true;
        }

        $this->dumpIt('Error hm?'); //return false; // Keine Ressourcendaten vorhanden
    }

    public function completeBuild()
    {
        $currentTime = time();

        // Finde alle Gebäude, deren Bauzeit abgeschlossen ist
        $completedBuildings = DeUserTech::where('user_id', $this->user_id)
            ->where('time_finished', '<=', $currentTime)
            ->get();

        foreach ($completedBuildings as $building) {
            $building->time_finished = null; // Bau beendet, keine Wartezeit mehr
            $building->save();
        }
    }

    public function accelerateBuild($buildingId, $reductionSeconds)
    {
        $tech = DeUserTech::where('user_id', $this->user_id)
            ->where('tech_id', $buildingId)
            ->first();

        if ($tech) {
            $currentEndTime = $tech->time_finished;
            $newEndTime = $currentEndTime - $reductionSeconds;

            $tech->time_finished = max($newEndTime, time());
            $tech->save();

            $this->completeBuild(); // Prüfen, ob der Bau durch die Beschleunigung abgeschlossen wurde
            return true;
        }

        return false;
    }

    private function getBuildingById($id)
    {
        foreach ($this->buildings as $building) {
            if ($building['tech_id'] == $id) {
                return $building;
            }
        }
        return null;
    }

    public function canBuildByType($buildingId)
    {
        $building = $this->getBuildingById($buildingId);
        if (!$building) {
            return false; // Gebäude existiert nicht
        }

        // Prüfen, ob bereits ein Gebäude des gleichen Typs im Bau ist
        $currentlyBuilding = DeUserTech::where('user_id', $this->user_id)
            ->where('time_finished', '>', time())
            ->whereHas('techData', function ($query) use ($building) {
                $query->where('tech_typ', $building['tech_typ']); // Gleicher Typ
            })
            ->get(); // Statt exists() verwenden wir get(), um die Daten direkt auszugeben

//        dd('Aktive Bauvorhaben mit gleichen Typ:', $currentlyBuilding->toArray());
//dd($currentlyBuilding);
        return $currentlyBuilding; // Baubar, wenn kein Gebäude gleichen Typs im Bau ist
    }

    public function setSpeedModifier($modifier)
    {
        if ($modifier > 0) {
            $this->speedModifier = $modifier;
        }
    }
}
