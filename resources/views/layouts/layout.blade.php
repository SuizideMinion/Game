<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<div class="container">
{{--    <h1>Header</h1>--}}
    @yield('content')
</div>

<div class="footer">
    <div class="footer-left">
    </div>
    <div class="footer-middle">
        &copy; 2024 by sui`
    </div>
    <div class="footer-right d-flex justify-content-end">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Navigationsmenü
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach (getValidGetRoutes() as $route)
                    <li><a class="dropdown-item" href="{{ url($route) }}">{{ $route }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@yield('script')
</body>
</html>
