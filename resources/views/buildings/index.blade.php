@extends('blank')

@section('styles')
@endsection

@section('contend')

    <x-gui>
        <x-slot:title>
            Technologien
        </x-slot:title>
        <section class="shop-content">
            <!-- Shop menubar -->
            {{--            <div class="shop-menubar">--}}
            {{--                <ul class="d-flex gap-2">--}}
            {{--                    <li>--}}
            {{--                        <a href="#" class="active">All</a>--}}
            {{--                    </li>--}}
            {{--                    <li>--}}
            {{--                        <a href="#"><i class="fa-solid fa-apple-whole"></i></a>--}}
            {{--                    </li>--}}
            {{--                    <li>--}}
            {{--                        <a href="#"><i class="fa-solid fa-gun"></i></a>--}}
            {{--                    </li>--}}
            {{--                    <li>--}}
            {{--                        <a href="#"><i class="fa-solid fa-vest"></i></a>--}}
            {{--                    </li>--}}
            {{--                    <li>--}}
            {{--                        <a href="#"><i class="fa-solid fa-sign-hanging"></i></a>--}}
            {{--                    </li>--}}
            {{--                    <li>--}}
            {{--                        <a href="#"><i class="fa-solid fa-ellipsis"></i></a>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </div>--}}

            <!-- Shop products -->
            <div class="shop-products">
                <div class="inner h-100">
                    <div class="overflow-y-auto">
                        <div id="building-list" class="row product-grid">
{{--                                                        @dd($buildings)--}}
                            @foreach($buildings->buildings as $building)
                                @if($building->tech_typ == 3)
                                    @continue
                                @endif
                                @if(isset($building->get_user_techs[0]->time_finished) AND $building->get_user_techs[0]->time_finished < time())
                                    @continue
                                @endif
                                @if($building->tech_sort_id > 999)
                                    @continue
                                @endif
                                @if(is_array($building->can_build_without_ressources))
                                    @continue
                                @endif
{{--                                    @dump($buildings,$building, $building->get_user_techs[0]->time_finished ?? '', time())--}}
                                <div class="element-card">
                                    <div class="front-facing"
                                    @if (isset($building->tech_name))
                                        {{--                                                 style="background-image: url('{{ asset('/images/technologies/'.  mb_strtolower(explode(';', $building->tech_name)[0] ?? '') .'.png') }}');border: 0;"--}}
                                        @endif>
                                        <h1 class="abr">{{ explode(';', $building->tech_name)[auth()->user()->deUserData->rasse - 1] ?? '' }}</h1>
                                        <div class="title">
                                            <p>
{{--                                                @dump($building->tech_build_time, getDefaultVariable('tech_build_time_faktor'), $building->tech_build_time * getDefaultVariable('tech_build_time_faktor'))--}}
                                                <strong>Bauzeit: {{ formatZeit(round($building->tech_build_time * getDefaultVariable('tech_build_time_faktor'))) }}</strong>
                                            </p>
                                            <li class="technologiesCardLi">
                                                <p>Kosten:</p>
                                                @foreach(explode(';', $building->tech_build_cost) as $cost)
                                                    @php($price = explode('x', $cost))

                                                    <span
                                                        style="{{ $price[1] >= auth()->user()->deUserData->{'restyp0' . str_replace('R', '', $price[0])} ? 'color: red;' : '' }}">
                                                        {{ __('global.'. $price[0]) }}: {{ shortenNumber($price[1]) }}
                                                    </span>

                                                @endforeach
                                            </li>
                                        </div>
                                        <span class="atomic-number">{{ $building->atomic_number ?? ''}}</span>
                                        <span class="atomic-mass">{{ $building->atomic_mass ?? ''}}</span>
                                        <p>
                                            @if( isset($building->get_user_techs[0]->time_finished) AND $building->get_user_techs[0]->time_finished > time() )
                                                <x-gui-button
                                                    class="countdown-button"
                                                    :datas="['data-time' => $building->get_user_techs[0]->time_finished - time()]"
                                                    name="Im Bau {{ formatZeit($building->get_user_techs[0]->time_finished - time()) }}">
                                                </x-gui-button>
                                            @else
                                                <x-gui-button
                                                    name="Bauen"
                                                    target="{{ route('buildings.build', $building->tech_id) }}"
                                                    :post="true"
                                                    :inputs="['building_id' => $building->tech_id]"
                                                ></x-gui-button>
                                            @endif
                                        </p>
                                        <div class="b-t-l"></div>
                                        <div class="b-t-l-t"></div>
                                        <div class="b-t-r"></div>
                                        <div class="b-t-r-t"></div>
                                        <div class="b-b-l"></div>
                                        <div class="b-b-l-b"></div>
                                        <div class="b-b-r"></div>
                                        <div class="b-b-r-b"></div>
                                    </div>
                                    <div class="back-facing">
                                        <p>{!! explode(';', $building->tech_desc)[auth()->user()->deUserData->rasse - 1] ?? '' !!}</p>
                                        <p>
                                            {{--                                            <a class="btn" href="{{ $building->link ?? ''}}" target="_blank">More--}}
                                            {{--                                                info</a>--}}

                                            <x-gui-button
                                                name="Mehr Informationen"
                                                :datas="[]"
                                                target="https://help.bgam.es/index.php?thread=de_de&post=26"
                                            ></x-gui-button>
                                        </p>
                                        <div class="b-t-l"></div>
                                        <div class="b-t-l-t"></div>
                                        <div class="b-t-r"></div>
                                        <div class="b-t-r-t"></div>
                                        <div class="b-b-l"></div>
                                        <div class="b-b-l-b"></div>
                                        <div class="b-b-r"></div>
                                        <div class="b-b-r-b"></div>
                                    </div>


                                </div>
                                {{--                                <div class="element-card product-card {{ (!$building->get_user_techs ? '':'d-none') }}" data-bs-placement="right" data-bs-toggle="tooltip"--}}
                                {{--                                     data-bs-placement="top" title="{{ $building->tech_desc }}">--}}
                                {{--                                    <p class="title">{{ explode(';', $building->tech_name)[0] }} -> {{ $building->tech_typ }}</p>--}}
                                {{--                                    <div class="img">--}}
                                {{--                                    <span>--}}
                                {{--                                        <p>--}}
                                {{--                                            <strong>{{ $building->tech_build_time }}</strong>--}}
                                {{--                                        </p>--}}
                                {{--                                        <ul>--}}
                                {{--                                        <p>Kosten:</p>--}}
                                {{--                                            <li class="technologiesCardLi">--}}
                                {{--                                                @foreach(explode(';', $building->tech_build_cost) as $cost)--}}
                                {{--                                                    <span>{{$cost}}</span>--}}
                                {{--                                                @endforeach--}}
                                {{--                                            </li>--}}
                                {{--                                        </ul>--}}
                                {{--                                        <p>Status: ${status}</p>--}}
                                {{--                                    </span>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="product-badge">--}}
                                {{--                                        <p><small>x</small>200</p>--}}
                                {{--                                    </div>--}}
                                {{--                                    @if(!$building->get_user_techs)--}}
                                {{--                                    <button type="button" onclick="buildBuilding({{ $building->tech_id }})">--}}
                                {{--                                        <div class="btn-inner d-flex justify-content-center gap-1 align-items-center">--}}
                                {{--                                            Bauen--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="b-t-l"></div>--}}
                                {{--                                        <div class="b-t-l-t"></div>--}}
                                {{--                                        <div class="b-t-r"></div>--}}
                                {{--                                        <div class="b-t-r-t"></div>--}}
                                {{--                                        <div class="b-b-l"></div>--}}
                                {{--                                        <div class="b-b-l-b"></div>--}}
                                {{--                                        <div class="b-b-r"></div>--}}
                                {{--                                        <div class="b-b-r-b"></div>--}}
                                {{--                                    </button>--}}
                                {{--                                    @endif--}}
                                {{--                                    <div class="b-t-l"></div>--}}
                                {{--                                    <div class="b-t-l-t"></div>--}}
                                {{--                                    <div class="b-t-r"></div>--}}
                                {{--                                    <div class="b-t-r-t"></div>--}}
                                {{--                                    <div class="b-b-l"></div>--}}
                                {{--                                    <div class="b-b-l-b"></div>--}}
                                {{--                                    <div class="b-b-r"></div>--}}
                                {{--                                    <div class="b-b-r-b"></div>--}}
                                {{--                                </div>--}}

                                {{--                                    <div class="back-facing">--}}
                                {{--                                        <p>{{ $building->tech_desc }}</p>--}}
                                {{--                                        <p><a class="btn" href="{{ $building->tech_name }}" target="">More info</a></p>--}}
                                {{--                                    </div>--}}

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{--        <div class="chat-container" id="building-list" >--}}
        <div id="building-list" class="row">
            <!-- Gebäudeliste wird dynamisch durch JavaScript geladen -->
        </div>
        {{--        </div>--}}

        <x-slot:footer></x-slot:footer>
    </x-gui>
    {{--    <div class="container">--}}
    {{--        <h1 class="text-center mb-4">Willkommen zum Gebäude-Spiel</h1>--}}
    {{--        <div class="d-flex justify-content-center mb-3">--}}
    {{--            <button id="filter-all" class="btn btn-primary mx-2">Alle</button>--}}
    {{--            <button id="filter-completed" class="btn btn-success mx-2">Fertig</button>--}}
    {{--            <button id="filter-buildable" class="btn btn-warning mx-2">Baubar</button>--}}
    {{--        </div>--}}
    {{--        <div id="building-list" class="row">--}}
    {{--            <!-- Gebäudeliste wird dynamisch durch JavaScript geladen -->--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Starte den Countdown für jeden Button mit "countdown-button"-Klasse
            $('.countdown-button').each(function () {
                let $button = $(this);                // Button-Element
                let remainingTime = parseInt($button.data('time')); // Verbleibende Zeit aus data-time

                // Countdown anzeigen
                function updateCountdown() {
                    if (remainingTime > 0) {
                        remainingTime--; // Verringere die Zeit um 1 Sekunde
                        $button.text('Im Bau ' + formatTime(remainingTime)); // Aktualisiere die Button-Anzeige
                    } else {
                        $button.text('Fertig!'); // Wenn der Countdown endet
                        clearInterval(timer); // Stoppe den Countdown
                    }
                }

                // Zeitformatierung (HH:MM:SS)
                function formatTime(seconds) {
                    let hours = Math.floor(seconds / 3600);
                    let minutes = Math.floor((seconds % 3600) / 60);
                    let secs = seconds % 60;

                    return `${hours > 0 ? hours + ':' : ''}${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                }

                // Initialisiere den Countdown und starte das Intervall
                updateCountdown(); // Zeige die anfängliche Zeit
                let timer = setInterval(updateCountdown, 1000); // Aktualisiere jede Sekunde
            });
        });
    </script>
    <!--suppress JSUnresolvedReference -->
    <script>
        // let currentFilter = 'buildable';
        //
        // $(document).ready(function () {
        //     // Globale Variable für die aktuelle Sortierung (Standard: 'all')
        //
        //     // Lädt standardmäßig alle Gebäude
        //     loadBuildings(currentFilter);
        //
        //     // Event-Listener für die Buttons
        //     $(document).on('click', '#filter-all', function () {
        //         currentFilter = 'all'; // Speichern: Aktuelle Sortierung ist 'all'
        //         loadBuildings(currentFilter);
        //     });
        //
        //     $(document).on('click', '#filter-completed', function () {
        //         currentFilter = 'completed'; // Speichern: Aktuelle Sortierung ist 'completed'
        //         loadBuildings(currentFilter);
        //     });
        //
        //     $(document).on('click', '#filter-buildable', function () {
        //         currentFilter = 'buildable'; // Speichern: Aktuelle Sortierung ist 'buildable'
        //         loadBuildings(currentFilter);
        //     });
        // });
        //
        // function loadBuildings(filter = 'all') {
        //     $.get('/api/buildings/available', function (data) {
        //         if (data.status === 'success' && data.buildings && data.buildings.original && data.buildings.original.buildings) {
        //             const buildings = data.buildings.original.buildings;
        //             const userResources = data.user; // Ressourcen des Benutzers
        //             const currentTime = Math.floor(Date.now() / 1000); // Aktueller Zeitpunkt in Sekunden
        //             const buildingListDiv = $('#building-list');
        //             buildingListDiv.empty();
        //
        //             const buildingTypesInProgress = new Set(); // Set für Typen, die bereits im Bau sind
        //
        //             // Erste Schleife: Prüfen, welche Typen im Bau sind
        //             buildings.forEach(function (building) {
        //                 const isUnderConstruction = building.get_user_techs.length > 0 &&
        //                     building.get_user_techs[0].time_finished > currentTime;
        //
        //                 if (isUnderConstruction) {
        //                     buildingTypesInProgress.add(building.tech_typ); // Typ im Bau vormerken
        //                 }
        //             });
        //
        //             // Zweite Schleife: Gebäude rendern
        //             for (const building of buildings) {
        //                 if (building.tech_typ === 3) {
        //                     continue; // Überspringt die aktuelle Iteration
        //                 }
        //                 // Prüfen, ob das Gebäude fertiggestellt ist
        //                 const isCompleted = building.get_user_techs.length > 0 &&
        //                     building.get_user_techs[0].time_finished <= currentTime;
        //
        //                 // Prüfen, ob das Gebäude gerade im Bau ist
        //                 const isUnderConstruction = building.get_user_techs.length > 0 &&
        //                     building.get_user_techs[0].time_finished > currentTime;
        //
        //                 // Prüfen, ob der Typ schon im Bau ist
        //                 const isTypeInProgress = buildingTypesInProgress.has(building.tech_typ);
        //
        //                 // Gebäude ist baubar, wenn nicht fertiggestellt, nicht im Bau und alle Voraussetzungen erfüllt sind
        //                 const isBuildable = !isCompleted && !isUnderConstruction &&
        //                     (!building.tech_vor || checkTechRequirements(building.tech_vor));
        //
        //                 //DEBUG:
        //                 // if (building.get_user_techs.length > 0) console.log(building.tech_id + ' -> ' + building.get_user_techs[0].time_finished + ' -> ' + currentTime + ' -> ' + isUnderConstruction + ' -> ' + isCompleted)
        //
        //                 // Filterlogik anwenden
        //                 if (
        //                     (filter === 'completed' && !isCompleted) ||   // Nur fertig, wenn "Fertig" ausgewählt
        //                     (filter === 'buildable' && !isBuildable)     // Nur baubar, wenn "Baubar" ausgewählt
        //                 ) {
        //                     if (!isUnderConstruction) return; // Dieses Gebäude wird beim aktuellen Filter nicht angezeigt
        //                 }
        //
        //                 // Technologiedaten aufbereiten
        //                 const techNames = building.tech_name.split(';');  // Namen splitten
        //                 const techDescs = building.tech_desc.split(';');  // Beschreibungen splitten
        //                 const techCosts = building.tech_build_cost.split(';'); // Kosten splitten
        //                 const buildingName = techNames[0];
        //                 const buildingDesc = techDescs[0];
        //
        //                 // Ressourcen prüfen und HTML für die Kosten erstellen
        //                 const costList = techCosts.map(cost => {
        //                     const [resourceKey, requiredAmount] = cost.split('x'); // Ressourcen-Key und benötigte Menge
        //                     const userResourceField = `restyp${resourceKey.substring(1).padStart(2, '0')}`; // Ressourcen-Key des Benutzers
        //
        //                     const userResourceAmount = userResources[userResourceField] || 0; // Benutzer-Ressource abrufen
        //                     const isEnoughResource = userResourceAmount >= parseFloat(requiredAmount); // Ressourcen vergleichen
        //
        //                     // Optische Darstellung (rot bei fehlenden Ressourcen)
        //                     const resourceClass = isEnoughResource ? 'text-success' : 'text-danger';
        //                     return `<span class="${resourceClass}">${resourceKey}: ${requiredAmount}</span>`;
        //                     // return `<span class="${resourceClass}">${resourceKey}: ${userResourceAmount} / ${requiredAmount}</span>`;
        //                 }).join('<br>');
        //
        //                 // Konvertiere Bauzeit
        //                 const buildTime = formatTime(building.tech_build_time);
        //
        //                 // Statusanzeige
        //                 let status = '';
        //                 if (isUnderConstruction) {
        //                     status = `<span class="text-warning">Wird gerade gebaut (fertig um ${formatDate(building.get_user_techs[0].time_finished)})</span>`;
        //                 } else if (isCompleted) {
        //                     status = `<span class="text-success">Fertiggestellt</span>`;
        //                 }
        //
        //                 // Button anzeigen oder nicht (abhängig von "type_in_progress")
        //                 const buildButtonHtml = isBuildable && !isTypeInProgress
        //                     ? `<button type="button" onclick="buildBuilding(${building.tech_id})">
        //                                 <div class="btn-inner d-flex justify-content-center gap-1 align-items-center">
        //                                     Bauen
        //                                 </div>
        //                                 <div class="b-t-l"></div>
        //                                 <div class="b-t-l-t"></div>
        //                                 <div class="b-t-r"></div>
        //                                 <div class="b-t-r-t"></div>
        //                                 <div class="b-b-l"></div>
        //                                 <div class="b-b-l-b"></div>
        //                                 <div class="b-b-r"></div>
        //                                 <div class="b-b-r-b"></div>
        //                             </button>`
        //                     : ''; // Kein Button anzeigen, wenn Typ im Bau ist
        //
        //                 // Card HTML
        //                 const buildingHtml = `
        //                 <div class="product-card" data-bs-placement="right" data-bs-toggle="tooltip" data-bs-placement="top" title="${buildingDesc}">
        //                             <p class="title">${buildingName}</p>
        //                             <div class="img">
        //                                 <span><p><strong>${buildTime}</strong></p>
        //                     <ul>
        //                     <p>Kosten:</p>
        //                         <li class="technologiesCardLi">${costList}</li>
        //                     </ul>
        //                     ${status
        //                     ? `<p>Status: ${status}</p>`
        //                     : ''
        //                 }</span>
        //                             </div>
        //                             <div class="product-badge">
        //                                 <p><small>x</small>200</p>
        //                             </div>
        //                                     ${buildButtonHtml}
        //
        //                             <div class="b-t-l"></div>
        //                             <div class="b-t-l-t"></div>
        //                             <div class="b-t-r"></div>
        //                             <div class="b-t-r-t"></div>
        //                             <div class="b-b-l"></div>
        //                             <div class="b-b-l-b"></div>
        //                             <div class="b-b-r"></div>
        //                             <div class="b-b-r-b"></div>
        //                         </div>
        //         `;
        //
        //                 buildingListDiv.append(buildingHtml);
        //             }
        //
        //             // Tooltips aktivieren
        //             activateTooltips();
        //         } else {
        //             console.error('Fehler in den empfangenen Daten: ', data.message || 'Falsches Format oder leere Liste');
        //         }
        //     }).fail(function (jqXHR, textStatus, errorThrown) {
        //         console.error('Fehler beim Abrufen der Gebäudeliste: ', textStatus, errorThrown);
        //     });
        // }

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
