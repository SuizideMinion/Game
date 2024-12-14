@extends('layouts.layout')

@section('style')
@endsection

@section('content')
    <div class="container">
{{--        <h1 class="text-center mb-4">Willkommen zum Gebäude-Spiel</h1>--}}
        <div class="d-flex justify-content-center mb-3">
            <button id="filter-all" class="btn btn-primary mx-2">Alle</button>
            <button id="filter-completed" class="btn btn-success mx-2">Fertig</button>
            <button id="filter-buildable" class="btn btn-warning mx-2">Baubar</button>
        </div>
        <div id="building-list" class="row">
            <!-- Gebäudeliste wird dynamisch durch JavaScript geladen -->
        </div>
    </div>
@endsection

@section('script')
    <!--suppress JSUnresolvedReference -->
    <script>
        let currentFilter = 'buildable';

        $(document).ready(function () {
            // Globale Variable für die aktuelle Sortierung (Standard: 'all')

            // Lädt standardmäßig alle Gebäude
            loadBuildings(currentFilter);

            // Event-Listener für die Buttons
            $(document).on('click', '#filter-all', function () {
                currentFilter = 'all'; // Speichern: Aktuelle Sortierung ist 'all'
                loadBuildings(currentFilter);
            });

            $(document).on('click', '#filter-completed', function () {
                currentFilter = 'completed'; // Speichern: Aktuelle Sortierung ist 'completed'
                loadBuildings(currentFilter);
            });

            $(document).on('click', '#filter-buildable', function () {
                currentFilter = 'buildable'; // Speichern: Aktuelle Sortierung ist 'buildable'
                loadBuildings(currentFilter);
            });
        });

        function loadBuildings(filter = 'all') {
            $.get('/api/buildings/available', function (data) {
                if (data.status === 'success' && data.buildings && data.buildings.original && data.buildings.original.buildings) {
                    const buildings = data.buildings.original.buildings;
                    const userResources = data.user; // Ressourcen des Benutzers
                    const currentTime = Math.floor(Date.now() / 1000); // Aktueller Zeitpunkt in Sekunden
                    console.log(currentTime);
                    const buildingListDiv = $('#building-list');
                    buildingListDiv.empty();

                    const buildingTypesInProgress = new Set(); // Set für Typen, die bereits im Bau sind

                    // Erste Schleife: Prüfen, welche Typen im Bau sind
                    buildings.forEach(function (building) {
                        const isUnderConstruction = building.get_user_techs.length > 0 &&
                            building.get_user_techs[0].time_finished > currentTime;

                        if (isUnderConstruction) {
                            buildingTypesInProgress.add(building.tech_typ); // Typ im Bau vormerken
                        }
                    });

                    // Zweite Schleife: Gebäude rendern
                    buildings.forEach(function (building) {
                        // Prüfen, ob das Gebäude fertiggestellt ist
                        const isCompleted = building.get_user_techs.length > 0 &&
                            building.get_user_techs[0].time_finished <= currentTime;

                        // Prüfen, ob das Gebäude gerade im Bau ist
                        const isUnderConstruction = building.get_user_techs.length > 0 &&
                            building.get_user_techs[0].time_finished > currentTime;

                        // Prüfen, ob der Typ schon im Bau ist
                        const isTypeInProgress = buildingTypesInProgress.has(building.tech_typ);

                        // Gebäude ist baubar, wenn nicht fertiggestellt, nicht im Bau und alle Voraussetzungen erfüllt sind
                        const isBuildable = !isCompleted && !isUnderConstruction &&
                            (!building.tech_vor || checkTechRequirements(building.tech_vor));

                        //DEBUG:
                        // if (building.get_user_techs.length > 0) console.log(building.tech_id + ' -> ' + building.get_user_techs[0].time_finished + ' -> ' + currentTime + ' -> ' + isUnderConstruction + ' -> ' + isCompleted)

                        // Filterlogik anwenden
                        if (
                            (filter === 'completed' && !isCompleted) ||   // Nur fertig, wenn "Fertig" ausgewählt
                            (filter === 'buildable' && !isBuildable)     // Nur baubar, wenn "Baubar" ausgewählt
                        ) {
                            if(!isUnderConstruction) return; // Dieses Gebäude wird beim aktuellen Filter nicht angezeigt
                        }

                        // Technologiedaten aufbereiten
                        const techNames = building.tech_name.split(';');  // Namen splitten
                        const techDescs = building.tech_desc.split(';');  // Beschreibungen splitten
                        const techCosts = building.tech_build_cost.split(';'); // Kosten splitten
                        const buildingName = techNames[0];
                        const buildingDesc = techDescs[0];

                        // Ressourcen prüfen und HTML für die Kosten erstellen
                        const costList = techCosts.map(cost => {
                            const [resourceKey, requiredAmount] = cost.split('x'); // Ressourcen-Key und benötigte Menge
                            const userResourceField = `restyp${resourceKey.substring(1).padStart(2, '0')}`; // Ressourcen-Key des Benutzers

                            const userResourceAmount = userResources[userResourceField] || 0; // Benutzer-Ressource abrufen
                            const isEnoughResource = userResourceAmount >= parseFloat(requiredAmount); // Ressourcen vergleichen

                            // Optische Darstellung (rot bei fehlenden Ressourcen)
                            const resourceClass = isEnoughResource ? 'text-success' : 'text-danger';
                            return `<span class="${resourceClass}">${resourceKey}: ${userResourceAmount} / ${requiredAmount}</span>`;
                        }).join('<br>');

                        // Konvertiere Bauzeit
                        const buildTime = formatTime(building.tech_build_time);

                        // Statusanzeige
                        let status = '';
                        if (isUnderConstruction) {
                            status = `<span class="text-warning">Wird gerade gebaut (fertig um ${formatDate(building.get_user_techs[0].time_finished)})</span>`;
                        } else if (isCompleted) {
                            status = `<span class="text-success">Fertiggestellt</span>`;
                        }
                        console.log(status);

                        // Button anzeigen oder nicht (abhängig von "type_in_progress")
                        const buildButtonHtml = isBuildable && !isTypeInProgress
                            ? `<button class="btn btn-custom build-button" onclick="buildBuilding(${building.tech_id})">Bauen</button>`
                            : ''; // Kein Button anzeigen, wenn Typ im Bau ist

                        // Card HTML
                        const buildingHtml = `
                <div class="col-md-4 mb-3">
                    <div class="card building-card">
                        <!-- Tooltip -->
                        <div
                            class="card-header"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="${buildingDesc}">
                            ${buildingName} <small>(Level ${building.tech_level})</small>
                        </div>
                        <div class="card-body">
                            <p><strong>Bauzeit:</strong> ${buildTime}</p>
                            <p>Kosten:</p>
                            <ul>
                                <li>${costList}</li>
                            </ul>
                            ${status
                            ? `<p>Status: ${status}</p>`
                            : ''
                        }
                            ${buildButtonHtml} <!-- "Bauen"-Button -->
                        </div>
                    </div>
                </div>`;

                        buildingListDiv.append(buildingHtml);
                    });

                    // Tooltips aktivieren
                    activateTooltips();
                } else {
                    console.error('Fehler in den empfangenen Daten: ', data.message || 'Falsches Format oder leere Liste');
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error('Fehler beim Abrufen der Gebäudeliste: ', textStatus, errorThrown);
            });
        }

        function startTimer(buildingId, initialSeconds) {
            const timerElement = $(`#timer-${buildingId}`);
            let seconds = initialSeconds;

            if (timerElement.length) {
                const intervalId = setInterval(() => {
                    if (seconds > 0) {
                        seconds -= 1;
                        timerElement.text(`Fertig in: ${formatTime(seconds)}`);
                    } else {
                        clearInterval(intervalId);
                        timerElement.text('Abgeschlossen');
                        loadBuildings();
                    }
                }, 1000);
            } else {
                console.error(`Timer-Element für Gebäude ${buildingId} nicht gefunden.`);
            }
        }

        function formatTime(seconds) {
            const days = Math.floor(seconds / (24 * 3600));
            const hours = Math.floor((seconds % (24 * 3600)) / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            const daysDisplay = days > 0 ? `${days}d ` : "";
            const hoursDisplay = hours > 0 ? `${hours}h ` : "";
            const minutesDisplay = minutes > 0 ? `${minutes}m ` : "";
            const secondsDisplay = secs > 0 ? `${secs}s` : "";

            return `${daysDisplay}${hoursDisplay}${minutesDisplay}${secondsDisplay}`.trim();
        }

        function formatDate(timestamp) {
            const date = new Date(timestamp * 1000);
            return date.toLocaleString(); // Gibt Datum und Zeit im lokalen Format zurück
        }

        function checkTechRequirements(requirements) {
            const techs = requirements.split(';'); // Anforderungen splitten
            // Dummy-Logik. Hier können Abhängigkeiten aus einer anderen API geprüft werden.
            return techs.every(req => req.startsWith('T')); // Überprüfe, ob alle Anforderungen erfüllt sind
        }

        function buildBuilding(buildingId) {
            $.ajax({
                url: '/api/buildings/build',
                type: 'POST',
                data: JSON.stringify({building_id: buildingId}),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    // Beim Erneuern der Gebäude-Liste den aktuellen Filter beibehalten
                    loadBuildings(currentFilter); // Ladung mit 'currentFilter' als Sortierung
                },
                error: function (error) {
                    console.error('Fehler beim Bau des Gebäudes:', error);
                }
            });
        }

        function accelerateBuilding(buildingId) {
            $.ajax({
                url: '/api/buildings/accelerate',
                type: 'POST',
                data: JSON.stringify({building_id: buildingId, reduction_seconds: 600}),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    loadBuildings();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Fehler beim Beschleunigen des Baus:', textStatus, errorThrown);
                }
            });
        }

        function activateTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    </script>
@endsection
