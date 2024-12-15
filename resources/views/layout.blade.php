<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        * {
            box-sizing: border-box;
        }

        /*primary: hsl(260, 100%, 80%);*/

        html,
        body {
            background-image: url("{{ asset('images/'. auth()->user()->deUserData->rasse .'.png') }}");
            background-size: cover; /* Bild deckt den Bereich ab */
            background-position: center; /* Zentriert das Bild */
            background-repeat: no-repeat; /* Verhindert Wiederholungen */
            height: 100vh; /* Höhe des Containers = 100% der Viewport-Höhe */
            width: 100vw;
        }

        body {
            margin: 0;
            display: grid;
            place-items: center;
            background-color: #222;
            font-family: system-ui, sans-serif;
        }

        /*nav,*/
        /*.nav-item {*/
        /*    display: flex;*/
        /*}*/

        .fr {
            margin-left: auto;
        }

        /*.dropdown-menu::before,*/
        /*.dropdown-menu::after {*/
        /*    border: none;*/
        /*    content: none;*/
        /*}*/

        nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 30px;
            border-radius: 6px;
            background-image: linear-gradient(
                rgb(48, 48, 48) 13%,
                rgb(30, 30, 30) 40%,
                #0c0d11 86%
            );
            color: rgba(255, 255, 255, 0.6);
            text-shadow: 0 -2px 0 black;
            cursor: pointer;
            box-shadow: 1px 2px 4px rgb(20, 20, 20), 0 4px 12px rgb(10, 10, 10);
            display: flex;
            flex-wrap: wrap;
            align-content: center;
            justify-content: center;
            align-items: baseline;
            z-index: 1051;
        }

        .nav-group {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0 1ch;
        }

        .nav-item {
            /*flex-direction: row-reverse;*/
            font-size: 0.8999rem;
            line-height: 1rem;
            align-items: center;
            /*justify-content: space-between;*/
            transition: all 80ms ease;

            &.active {
                color: hsl(260, 100%, 80%);
                text-shadow: 0 0 3px hsla(260, 100%, 70%, 0.7);
            }

            &:not(.active):hover {
                color: rgba(255, 255, 255, 0.87);
            }

            &:hover > .icon .subicon {
                height: 32px;
                width: 32px;
                border-radius: 32px;
                top: -16px;
                right: -16px;
                border-color: white;
            }

            &:not(:first-of-type) {
                border-left: 1px solid rgb(60, 60, 60);
            }

            &:not(:last-of-type) {
                border-right: 0.1rem solid black;
            }

            /*&:is(:last-of-type) {*/
            /*    margin-right: 20px;*/
            /*}*/

            a {
                color: inherit;
                text-decoration: none;
                padding: 1ch;
            }

            .icon {
                padding: 1ch;
                position: relative;

                .subicon {
                    text-shadow: none;
                    transition: all 40ms ease;
                    position: absolute;
                    top: -3px;
                    right: -3px;
                    background: red;
                    color: white;
                    box-shadow: 0 0 4px rgba(41, 41, 41, 0.405);
                    width: 18px;
                    height: 18px;
                    border-radius: 14px;
                    font-size: 0.7em;
                    font-weight: 700;
                    display: inline-grid;
                    place-items: center;
                    border: 2px solid rgba(255, 128, 128, 1);
                }
            }

            .icon > svg {
                max-width: 16px;
            }
        }

        .nav-item.dropdown .dropdown-menu {
            position: absolute;
            top: -180%; /* Abstand nach oben anpassen */
            left: 0;
            background: #333; /* Passend zum Design */
            color: rgba(255, 255, 255, 0.87);
            border: 1px solid #444;
            border-radius: 4px;
        }

        .nav-item.dropdown .dropdown-menu .dropdown-item {
            padding: 8px 12px;
            color: #fff;
        }

        .nav-item.dropdown .dropdown-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .resource-bar {
            font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: absolute;
            top: 0;
            background: linear-gradient(180deg, #2a2f3a, #1d222d); /* Metall-Verlauf */
            padding: 10px 20px;
            width: 860px;
            height: 30px;
            border: 2px solid #333;
            border-radius: 10px; /* Oberer Rundung */
            clip-path: polygon(
                0 0, 100% 0, 100% calc(100% - 15px),
                calc(100% - 20px) 100%, 20px 100%, 0 calc(100% - 15px)
            );
            box-shadow: inset 0 0 5px #000, /* Innerer Schatten */ 0 0 10px rgba(0, 0, 0, 0.8);
            z-index: 1051;
        }

        /* Ressourcen */
        .resource, .center-icon {
            display: flex;
            align-items: center;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            margin: 0 10px;
            position: relative;
        }

        .icon {
            margin-right: 8px;
            filter: drop-shadow(0 0 3px #ffc107); /* Glow-Effekt */
        }

        /* Mitte hervorheben */
        .center-icon {
            font-size: 35px;
            color: #00bcd4;
            margin: 0 30px;
            text-shadow: 0 0 8px #00bcd4;
        }

        /* Ressourcen Farben */
        .resource:nth-child(1) .icon {
            color: #ffc107;
        }

        .resource:nth-child(3) .icon {
            color: #00bcd4;
        }

        .resource:nth-child(5) .icon {
            color: #e91e63;
        }

        .resource:nth-child(7) .icon {
            color: #4caf50;
        }

        #search-input {
            padding: 5px 10px;
            font-size: 1rem;
            border: 0 solid #ccc;
            border-radius: 4px;
            display: inline-block;
            margin-left: 5px;
        }

        .d-none {
            display: none;
        }

        .copy {
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            margin: 0 10px;
            position: relative;
        }

        #head {
            position: fixed;
            bottom: 0;
            left: calc(50% - 100px);
            width: 200px; /* Kleine Größe - Bild und Container */
            height: 200px;
            display: flex; /* Flexbox für zentrierten Inhalt */
            align-items: center;
            z-index: 1051;
        }

        /* Medienabfragen für mobile Geräte */
        @media (max-width: 1200px) {
            nav {
                font-size: 12px; /* Kleine Schrift */
            }

            .nav-item {
                font-size: 11px;
                padding: 8px 5px;
            }

            .resource-bar {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(70px, 1fr)); /* Raster für Ressourcen */
                grid-gap: 10px; /* Platz zwischen Grid-Elementen */
                padding: 5px;
                width: calc(100% - 10px);
            }

            .resource {
                font-size: 9px; /* Kleinere Textgröße */
            }

            .center-icon {
                font-size: 20px; /* Kleinere Mitte-Icons */
            }

            #head {
                width: 80px; /* Bild weiter verkleinert */
                height: 80px;
                left: calc(50% - 40px);
            }

            #head img {
                width: 100%;
                height: 100%;
            }

        }

        /* Für sehr kleine Geräte */
        @media (max-width: 480px) {
            #head {
                width: 50px; /* Noch kleiner bei kleinen Geräten */
                height: 50px;
                left: calc(50% - 25px);
            }

            #head img {
                width: 100%;
                height: 100%;
            }

            nav {
                flex-wrap: wrap;
                font-size: 10px;
            }

            .resource-bar {
                grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
                margin: 5px auto;
            }

            .resource {
                font-size: 8px; /* Noch kleinere Schrift */
            }
        }

        #embedOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Schwarzer transparenter Hintergrund */
            z-index: 1050; /* Über Modal-Ebene legen */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .embed-container {
            position: relative;
            width: 90%; /* Standardbreite */
            height: 80%; /* Standardhöhe */
            border-radius: 8px; /* Runde Kanten */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Schatten-Effekt */
            overflow: hidden; /* Inhalt begrenzen */
            transition: transform 0.3s ease, width 0.3s ease, height 0.3s ease; /* Weiche Übergänge */
        }

        .embed-container iframe {
            width: 100%;
            height: 100%; /* Iframe passend einfügen */
        }

        .embed-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            cursor: pointer;
        }

        /* Dynamische Skalierung je nach Bildschirmbreite */

        /* Für kleinere Tablets und Mobilgeräte */
        @media (max-width: 768px) {
            .embed-container {
                width: 86%; /* Breite auf 95% begrenzen */
                height: 70%; /* Höhe reduzieren */
                transform: scale(0.95); /* Leichte Verkleinerung */
            }

            .embed-close {
                font-size: 18px; /* Kleinere Schließen-Taste */
                width: 25px;
                height: 25px;
                line-height: 25px;
            }
        }

        /* Für sehr kleine Geräte oder Smartphones */
        @media (max-width: 480px) {
            .embed-container {
                width: 100%; /* Breite auf Bildschirmgröße maximieren */
                height: 60%; /* Noch kleinere Höhe */
                transform: scale(0.9); /* Weitere Reduzierung */
            }

            .embed-close {
                font-size: 16px; /* Noch kleinere Schließen-Taste */
                width: 20px;
                height: 20px;
                line-height: 20px;
            }
        }

        /* Für größere Bildschirme (z. B. Widescreen) */
        @media (min-width: 1200px) {
            .embed-container {
                width: 86%; /* Reduzierte Breite */
                height: 85%; /* Erhöhte Höhe passend für große Geräte */
                transform: scale(1.1); /* Maßstab leicht vergrößern */
            }
        }

        .leftNavi {
            list-style: none;
            margin: 0;
            padding: 0;
            margin-left: 10px;
            margin-right: auto;
            background-image: linear-gradient(rgb(48, 48, 48) 13%, rgb(30, 30, 30) 40%, #0c0d11 86%);
            color: rgba(255, 255, 255, 0.6);
            text-shadow: 0 -2px 0 black;
            cursor: pointer;
            box-shadow: 1px 2px 4px rgb(20, 20, 20), 0 4px 12px rgb(10, 10, 10);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 10px;
        }

        /*.leftNavi li:nth-child(6) {*/
        /*    margin-top: 5rem;*/
        /*    padding-top: 1.25rem;*/
        /*    border-top: 1px solid #363664;*/
        /*}*/

        .leftNavi li + li {
            margin-top: .75rem;
        }

        .leftNavi a {
            color: #FFF;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 8px;
            position: relative;

            &:hover, &:focus, &.active {
                background-color: #30305a;
                outline: 0;

                span {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            i {
                font-size: 1.375rem;
            }

            span {
                position: absolute;
                background-color: #30305a;
                white-space: nowrap;
                padding: .5rem 1rem;
                border-radius: 6px;
                left: calc(100% + 1.5rem);
                transform-origin: center left;
                transform: scale(0);
                opacity: 0;
                transition: .15s ease;

                &:before {
                    content: "";
                    display: block;
                    width: 12px;
                    height: 12px;
                    position: absolute;
                    background-color: #30305a;
                    left: -5px;
                    top: 50%;
                    transform: translatey(-50%) rotate(45deg);
                    border-radius: 3px;
                }
            }
        }

        .dropdown-menu {
            font-size: 12px;
        }

    </style>
    @yield('style')
</head>
<body>
<ul class="leftNavi d-none">
    <li>
        <a href="#">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fas fa-image"></i>
            <span>Images</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fas fa-file-alt"></i>
            <span>Files</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fas fa-gamepad"></i>
            <span>Games</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fas fa-book"></i>
            <span>Books</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </li>
</ul>

<div class="resource-bar">
    <!-- Linke Ressource -->
    <div class="resource">
        <img src="{{ asset('images/resources/'. auth()->user()->deUserData->rasse .'_1.png') }}"
             style="width: 25px;" alt="">
        <span id="restyp01">{{ shortenNumber(auth()->user()->deUserData->restyp01, 1) }}</span>
    </div>

    <!-- Zweite Ressource -->
    <div class="resource">
        <img src="{{ asset('images/resources/'. auth()->user()->deUserData->rasse .'_2.png') }}"
             style="width: 25px;" alt="">
        <span id="restyp02">{{ shortenNumber(auth()->user()->deUserData->restyp02, 1) }}</span>
    </div>

    <!-- Zweite Ressource -->
    <div class="resource">
        <img src="{{ asset('images/resources/'. auth()->user()->deUserData->rasse .'_3.png') }}"
             style="width: 25px;" alt="">
        <span id="restyp03">{{ shortenNumber(auth()->user()->deUserData->restyp03, 1) }}</span>
    </div>

{{--    <!-- Mitte --> TODO:: On Attack Alert!--}}
    <div class="center-icon">
{{--        <img src="https://www.die-ewigen.com/degp3v2/g/forum_on.gif" style="width: 33px;" alt="">--}}
        <img src="{{asset('images/resources/RedAlert.gif')}}" style="width: 70px;" alt="">
    </div>

    <!-- Zweite Ressource -->
    <div class="resource">
        <img src="{{ asset('images/resources/'. auth()->user()->deUserData->rasse .'_4.png') }}"
             style="width: 25px;" alt="">
        <span id="restyp04">{{ shortenNumber(auth()->user()->deUserData->restyp04, 1) }}</span>
    </div>

    <!-- Dritte Ressource -->
    <div class="resource">
        <img src="{{ asset('images/resources/'. auth()->user()->deUserData->rasse .'_5.png') }}"
             style="width: 25px;" alt="">
        <span id="restyp05">{{ shortenNumber(auth()->user()->deUserData->restyp05, 1) }}</span>
    </div>

    <!-- Rechte Ressource -->
    <div class="resource">
        <span class="icon">🔋</span>
        <span id="credits">{{ shortenNumber(auth()->user()->deUserData->credits, 1) }}</span>
    </div>
</div>

<nav class="menu" id="nav">
    <div class="nav-group" style="{{ env('APP_DEBUG') ? 'margin-left:50px;':'' }}">
        <div class="nav-item dropdown active">
            <a href="#" id="dropdownLinks" data-bs-toggle="dropdown"
               aria-expanded="false">
                <span class="icon"><i data-feather="home"></i></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownLinks">
                @foreach (getValidGetRoutes() as $route)
                    <li>
                        <a class="dropdown-item" href="{{ url($route) }}" data-embed="true">{{ $route }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{--    <span class="nav-item">--}}
        {{--		<span class="icon">--}}
        {{--            <a href="#" id="search-toggle">Search</a>--}}
        {{--            <input type="text" id="search-input" class="d-none" placeholder="Enter your search..."/>--}}
        {{--            <i data-feather="search"></i>--}}
        {{--        </span>--}}
        {{--    </span>--}}

        {{--        <div class="nav-item">--}}
        {{--            <span class="icon"><i data-feather="star"></i></span>--}}
        {{--            <a href="#">Favorites</a>--}}
        {{--        </div>--}}
    </div>
    {{--    <div class="copy">&copy; by Die Ewigen 2001-2025</div>--}}
    <div class="nav-group fr">
        <div class="nav-item dropdown">
            <a href="#" id="dropdownNotifications" data-bs-toggle="dropdown"
               aria-expanded="false">
                <span class="icon">
                    <span class="subicon newNews"></span>
                    <i data-feather="bell"></i>
                </span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownNotifications"
                style="width: max-content;max-width: 400px;z-index: 10000" id="notifications">
            </ul>
        </div>
        <div class="nav-item dropdown">
            <a href="#" id="dropdownHyperfunk" data-bs-toggle="dropdown"
               aria-expanded="false">
                <span class="icon">
                    <span class="subicon hf_count"></span>
                    <i class="fas fa-image"></i>
                </span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownHyperfunk"
                style="width: max-content;z-index: 10000" id="hyperfuncs">
            </ul>
        </div>

        <div class="nav-item">
            <label>
                <input type="checkbox" id="pauseFetch">
            </label>
        </div>
        <div class="nav-item">
            <span id="loadTime"></span>
        </div>
        {{--        <div class="nav-item">--}}

        {{--            <a href="{{ asset('legacy/sysnews.php') }}" data-embed="true">--}}
        {{--                <span class="icon">--}}
        {{--                    <span class="subicon newNews">{{ auth()->user()->deUserData->userNews()->where('seen', 0)->count() }}</span>--}}
        {{--                    <i data-feather="bell"></i>--}}
        {{--                </span>--}}
        {{--            </a>--}}
        {{--        </div>--}}
        <div class="nav-item dropdown">

            <a
                href="#"
                id="dropdownLinks"
                data-bs-toggle="dropdown"
                aria-expanded="false"><span class="icon"><i data-feather="user"></i></span></a>
            <ul class="dropdown-menu" aria-labelledby="dropdownLinks">
                <li><a class="dropdown-item" href="{{ asset('legacy/overview.php') }}" data-embed="true">Übersicht</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/hyperfunk.php') }}" data-embed="true">Hyperfunk</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/sysnews.php') }}" data-embed="true">Nachrichten</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/ang_techs.php') }}"
                       data-embed="true">Technologien</a></li>
                <li><a class="dropdown-item" href="{{ asset('legacy/specialization.php') }}" data-embed="true">Spezialisierung</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/resource.php') }}" data-embed="true">Ressourcen</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/artefacts.php') }}" data-embed="true">Artefakte</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/auction.php') }}" data-embed="true">Auktionen</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/missions.php') }}" data-embed="true">Missionen</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/blackmarket.php') }}"
                       data-embed="true">Schwarzmarkt</a></li>
                <li><a class="dropdown-item" href="{{ asset('legacy/production.php') }}"
                       data-embed="true">Produktion</a></li>
                <li><a class="dropdown-item" href="{{ asset('legacy/military.php') }}" data-embed="true">Flotten</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/secret.php') }}" data-embed="true">Geheimdienst</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/sector.php') }}" data-embed="true">Sektor</a></li>
                <li><a class="dropdown-item" href="{{ asset('legacy/secstatus.php') }}"
                       data-embed="true">Sektorstatus</a></li>
                <li><a class="dropdown-item" href="{{ asset('legacy/allymain.php') }}" data-embed="true">Allianz</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/statistics.php') }}" data-embed="true">Statistik</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/toplist.php') }}" data-embed="true">Rangliste</a>
                </li>
                <li><a class="dropdown-item" href="{{ asset('legacy/options.php') }}" data-embed="true">Optionen</a>
                </li>
            </ul>
        </div>
        <div class="nav-item dropdown">
            <a
                href="#"
                id="dropdownProfile"
                data-bs-toggle="dropdown"
                aria-expanded="false"><span class="icon"><i data-feather="user"></i></span></a>
            <ul class="dropdown-menu" aria-labelledby="dropdownProfile">
                <li><a class="dropdown-item" href="#">View Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
                <li>
                    <a href="{{ asset('legacy/sector.php') }}" class="open-page-modal" data-bs-toggle="modal"
                       data-bs-target="#fullScreenModal">Buildings</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{--<div id="head">--}}
{{--    <!-- Kleines Bild in der minimierten Ansicht -->--}}
{{--    <img src="{{ asset('images/resources/head'. auth()->user()->deUserData->rasse .'.png') }}" alt="Kleine Ansicht"--}}
{{--         style="width: 200px">--}}
{{--</div>--}}

<div class="modal fade" id="fullScreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" style=""> <!-- Passt die Breite automatisch an den Inhalt an -->
        <div class="modal-content" style="background-color: transparent">
            <!-- Entfernt den Header und verschiebt den Close-Button -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"
                    style="position: absolute; top: 10px; right: 10px; z-index: 1050;color: white;font-size: xx-large;">
                X
            </button>

            <div class="modal-body" id="modalContent" style="padding-top: 40px;"> <!-- Abstand für den Button -->
                <!-- Der Seiteninhalt wird hier dynamisch geladen -->
                <p>Wird geladen...</p>
            </div>
        </div>
    </div>
</div>

<div id="embedOverlay" style="display: none;">
    <div class="embed-container">
        <button class="embed-close" id="closeEmbed">X</button>
        <!-- Der Inhalt wird als Iframe eingebettet -->
        <iframe id="embedIframe" src="" frameborder="0"></iframe>
    </div>
</div>

@yield('contend')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>--}}
<script>
    $(document).ready(function () {
        let globalData = '';

        // Feather Icons Replacements
        feather.replace();

        // Search Toggle Handling
        const searchToggle = $('#search-toggle');
        const searchInput = $('#search-input');

        if (searchToggle.length && searchInput.length) {
            searchToggle.on('click', function (e) {
                e.preventDefault();
                searchToggle.addClass('d-none');
                searchInput.removeClass('d-none').focus();
            });

            searchInput.on('blur', function () {
                if (!$.trim(searchInput.val())) {
                    searchInput.addClass('d-none');
                    searchToggle.removeClass('d-none');
                }
            });
        }

        // Modal Content Handling
        const modalContent = $('#modalContent');
        const fullScreenModal = $('#fullScreenModal');

        function loadInModal(url) {
            if (!modalContent.length) return;

            modalContent.html('<p>Wird geladen...</p>');

            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    modalContent.html(response);
                },
                error: function () {
                    modalContent.html('<p class="text-danger">Fehler beim Laden der Seite.</p>');
                }
            });
        }

        if (fullScreenModal.length) {
            $('[data-bs-target="#fullScreenModal"]').on('click', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) loadInModal(url);
            });

            fullScreenModal.on('click', 'a[href]', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) loadInModal('/legacy/' + url);
            });
        }

        // Embed Overlay Handling
        const embedOverlay = $('#embedOverlay');
        const closeEmbed = $('#closeEmbed');
        const embedIframe = $('#embedIframe');

        function openEmbed(url) {
            if (embedOverlay.length && embedIframe.length) {
                embedIframe.attr('src', url);
                embedOverlay.show();
                const iframe = document.getElementById('embedIframe');
                if (globalData) iframe.contentWindow.postMessage(globalData, '*'); // Ziel-Domain hier anpassen (anstelle von '*')
                else console.log('noch nicht geladen ')
            }
        }

        function closeEmbedOverlay() {
            if (embedOverlay.length) {
                embedIframe.attr('src', '');
                embedOverlay.hide();
            }
        }

        if (embedOverlay.length && closeEmbed.length) {
            closeEmbed.on('click', closeEmbedOverlay);
        }

        $('[data-embed="true"]').on('click', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) openEmbed(url);
        });

        // Überprüfen, ob die Klasse "newNews" existiert und Inhalt "0" hat
        $('.newNews').each(function () {
            if ($(this).text().trim() === '0') {
                $(this).hide(); // Element ausblenden
            }
        });

        let fetchInterval; // Variable for setInterval

        // Common function to update text and toggle visibility
        function updateElementTextAndVisibility(selector, value, precision = 1) {
            const element = $(selector);
            if (value > 0) {
                element.text(shortenNumber(value, precision)).show();
            } else {
                element.hide();
            }
        }

        // Function to fetch user data via API
        function fetchUserData() {
            $.ajax({
                url: '/api/user',
                method: 'GET',
                success: function (data) {
                    globalData = data;

                    const iframe = document.getElementById('embedIframe');

                    // Nachrichten per postMessage an das iframe senden
                    iframe.contentWindow.postMessage(data, '*'); // Ziel-Domain hier anpassen (anstelle von '*')

                    const {de_user_data, newNews, nachrichten, hf_count, user_hf_new} = data;

                    ['restyp01', 'restyp02', 'restyp03', 'restyp04', 'restyp05', 'credits'].forEach(key => {
                        $(`#${key}`).text(shortenNumber(de_user_data[key], 1));
                    });

                    updateElementTextAndVisibility('.newNews', newNews);
                    updateElementTextAndVisibility('.hf_count', hf_count);

                    const notificationList = $('#notifications');
                    if (nachrichten && Object.keys(nachrichten).length > 0) {
                        notificationList.empty().append(
                            Object.values(nachrichten)
                                .map(notification => `<li>${notification}</li><hr class="dropdown-divider">`)
                                .join('')
                        );
                    } else {
                        notificationList.empty();
                    }

                    // Hyperfunctions rendern
                    const hyperfuncsList = $('#hyperfuncs');
                    if (user_hf_new && Object.keys(user_hf_new).length > 0) {
                        hyperfuncsList.empty().append(
                            Object.values(user_hf_new)
                                .map(hf => `<li>${hf}</li><hr class="dropdown-divider">`)
                                .join('')
                        );
                    } else {
                        hyperfuncsList.empty(); // Leere Liste, wenn keine Hyperfunctions vorhanden
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching API data:', error);
                }
            });
        }

        // Start fetching process
        function startFetching() {
            if (!fetchInterval) {
                fetchInterval = setInterval(fetchUserData, 5000);
            }
        }

        // Stop fetching process
        function stopFetching() {
            clearInterval(fetchInterval);
            fetchInterval = null;
        }

        // Event listener for pause fetch checkbox
        $('#pauseFetch').on('change', function () {
            $(this).is(':checked') ? stopFetching() : startFetching();
        });

        // Initial fetching starts
        startFetching();

        // Event listener for notifications dropdown
        const notificationLink = $('#dropdownNotifications');
        const subIcon = $('.nav-item.dropdown .subicon'); // Improved selector
        notificationLink.on('click', function () {
            $.ajax({
                url: '/api/put/hideNews',
                method: 'GET',
                success: function () {
                    subIcon.hide(); // Simplified
                }
            });
        });
    });

    // Optimized shortenNumber function
    function shortenNumber(number, precision = 2) {
        if (number < 1000) return number.toString();

        const units = ['', 'K', 'M', 'B', 'T', 'Q', 'Qi', 'Sx', 'Sp', 'Oc', 'No', 'Dc', 'Ud', 'Dd', 'Td', 'Qd', 'Qid', 'Sxd', 'Spd'];
        const unitIndex = Math.min(Math.floor(Math.log10(number) / 3), units.length - 1);

        const shortNumber = number / Math.pow(1000, unitIndex);
        return `${shortNumber.toFixed(precision)}${units[unitIndex]}`;
    }

    function parseBBCode(bbcode) {
        // Mapping von BBCode zu HTML
        const bbcodeToHtml = {
            '\\[b\\](.*?)\\[/b\\]': '<strong>$1</strong>', // Bold
            '\\[i\\](.*?)\\[/i\\]': '<em>$1</em>',        // Italic
            '\\[u\\](.*?)\\[/u\\]': '<u>$1</u>',          // Underline
            '\\[s\\](.*?)\\[/s\\]': '<s>$1</s>',          // Strikethrough
            '\\[color=(.*?)\\](.*?)\\[/color\\]': '<span style="color:$1;">$2</span>', // Color
            '\\[quote\\](.*?)\\[/quote\\]': '<blockquote>$1</blockquote>', // Quote
            '\\[code\\](.*?)\\[/code\\]': '<pre>$1</pre>', // Code block
        };

        let hasMatch = true;

        // Solange BBCode-Tags gefunden werden, ersetze sie schrittweise (rekursiv)
        while (hasMatch) {
            hasMatch = false; // Standardmäßig keine Matches

            for (const regex in bbcodeToHtml) {
                const pattern = new RegExp(regex, 'gi'); // BBCode-Regex
                if (pattern.test(bbcode)) {
                    bbcode = bbcode.replace(pattern, bbcodeToHtml[regex]);
                    hasMatch = true; // Es wurde ein BBCode gefunden und ersetzt
                }
            }
        }

        return bbcode; // Vollständig geparster String
    }

</script>
</body>
</html>
