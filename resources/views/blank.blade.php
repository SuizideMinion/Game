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
</script>
@yield('scripts')
</body>
</html>
