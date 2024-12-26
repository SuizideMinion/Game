<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @if( getRace() == 1 )
        <style>
            :root {
                /* Colors */
                --primary_color: #1d3e70;
                --primary_light: #006fc9;
                --primary_light_dark: #05c6ff;
                --primary_dark: #111d2e;
                --secondary_color: #92bcfa;
                --primary_white: #bffcfb;
                --white_color: #ffffff;
                --black_color: #000000;

                --bg_rgb: rgba(0, 174, 254, 0.4);
                --bg_rgb_light: rgba(0, 174, 254, 0.6);
                --border_color: rgba(0, 97, 142, 0.47);
                --border_light_dark: rgba(0, 174, 254, 0.9);
                --bg_color: rgba(0, 174, 254);

                /* Transition */
                --transition: all ease .3s;

                /* Font Family */
                --body: "Exo 2", serif;
            }
        </style>
    @elseif( getRace() == 2 )
        <style>
            :root {
                /* Colors */
                --primary_color: #2beee7;
                --primary_light: #1b8280;
                --primary_light_dark: #114040;
                --primary_dark: #0d1e1f;
                --secondary_color: #acffff;
                --primary_white: #bffcfb;
                --white_color: #ffffff;
                --black_color: #000000;

                --bg_rgb: rgba(172, 255, 255, 0.4);
                --bg_rgb_light: rgba(43, 238, 231, 0.6);
                --border_color: rgba(43, 238, 231, 0.47);
                --border_light_dark: rgba(43, 238, 231, 0.9);
                --bg_color: rgba(43, 238, 231);

                /* Transition */
                --transition: all ease .3s;

                /* Font Family */
                --body: "Exo 2", serif;
            }
        </style>
    @elseif( getRace() == 3 )
        <style>
            :root {
                /* Colors */
                --primary_color: #ae0d0d;
                --primary_light: #b50f0f;
                --primary_light_dark: #e71313;
                --primary_dark: #390606;
                --secondary_color: #ff4646;
                --primary_white: #bffcfb;
                --white_color: #ffffff;
                --black_color: #000000;

                --bg_rgb: rgba(181, 15, 15, 0.5);
                --bg_rgb_light: rgba(219, 18, 18, 0.55);
                --border_color: rgba(255, 37, 37, 0.35);
                --border_light_dark: rgba(219, 18, 18, 0.9);
                --bg_color: rgba(219, 18, 18);

                /* Transition */
                --transition: all ease .3s;

                /* Font Family */
                --body: "Exo 2", serif;
            }
        </style>
    @elseif( getRace() == 4 )
        <style>
            :root {
                /* Colors */
                --primary_color: #209300;
                --primary_light: #24a301;
                --primary_light_dark: #2be901;
                --primary_dark: #0c220a;
                --secondary_color: #c4fe66;
                --primary_white: #bffcfb;
                --white_color: #ffffff;
                --black_color: #000000;

                --bg_rgb: rgba(21, 94, 1, 0.5);
                --bg_rgb_light: rgba(36, 179, 1, 0.5);
                --border_color: rgba(196, 254, 102, 0.55);
                --border_light_dark: rgba(36, 179, 1, 0.9);
                --bg_color: rgba(36, 179, 1);

                /* Transition */
                --transition: all ease .3s;

                /* Font Family */
                --body: "Exo 2", serif;
            }
        </style>
    @elseif( getRace() == 5 )
        <style>
            :root {
                /* Colors */
                --primary_color: #6a0dad; /* Dunkles Purple */
                --primary_light: #8a2be2; /* Helles Purple */
                --primary_light_dark: #7b1fa2; /* Etwas dunkleres Purple */
                --primary_dark: #4b0082; /* Sehr dunkles Purple */
                --secondary_color: #d8b4fe; /* Zartes Lila als Sekundärfarbe */
                --primary_white: #f3e8ff; /* Weiches Lila-Weiß */
                --white_color: #ffffff; /* Reinweiß */
                --black_color: #000000; /* Schwarz bleibt gleich */

                --bg_rgb: rgba(138, 43, 226, 0.5); /* Helles Purple mit Transparenz */
                --bg_rgb_light: rgba(106, 13, 173, 0.5); /* Primäres Purple mit Transparenz */
                --border_color: rgba(216, 180, 254, 0.55); /* Sekundärfarbe als Rand mit Transparenz */
                --border_light_dark: rgba(123, 31, 162, 0.9); /* Dunkleres Purple mit Transparenz */
                --bg_color: rgba(106, 13, 173); /* Primäres Purple */

                /* Transition */
                --transition: all ease .3s;

                /* Font Family */
                --body: "Exo 2", serif;
            }
        </style>
    @else
        <style>
            :root {
                /* Colors */
                --primary_color: #0ca496;
                --primary_light: #0abcba;
                --primary_light_dark: #1b8b8b;
                --primary_dark: #001519;
                --secondary_color: #c4fe66;
                --primary_white: #bffcfb;
                --white_color: #ffffff;
                --black_color: #000000;

                --bg_rgb: rgba(12, 164, 149, 0.2);
                --bg_rgb_light: rgba(12, 164, 149, 0.55);
                --border_color: rgba(196, 254, 102, 0.55);
                --border_light_dark: rgba(12, 164, 149, 0.9);
                --bg_color: rgb(12,164,150);

                /* Transition */
                --transition: all ease .3s;

                /* Font Family */
                --body: "Exo 2", serif;
            }
        </style>
    @endif


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">


    <!-- Font Family -->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    {{--    <link rel="stylesheet" href="{{ asset('css/main.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>

{{--    @yield('header')--}}
@yield('contend')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>--}}


<script>
    $(document).ready(function () {

        $('.element-card').on('click', function () {

            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
            } else {
                $('.element-card').removeClass('open');
                $(this).addClass('open');
            }

        });

    });
</script>
<script>
    function dismissIframe() {
        // Überprüfen, ob die Seite über ein iframe geöffnet wurde
        if (window.parent) {
            // Schließe das iframe, in dem diese Seite eingebunden ist
            window.parent.postMessage('close-iframe', '*'); // Nachricht senden, parent-Seite reagiert darauf
        }
    }

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@yield('scripts')
</body>
</html>
