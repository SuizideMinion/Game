<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login.index');


Route::resource('planets', \App\Http\Controllers\PlanetController::class);

Route::resource('building', \App\Http\Controllers\BuildingController::class);
Route::post('api/buildings/build', [\App\Http\Controllers\BuildingController::class, 'build'])->name('buildings.build');
Route::get('api/buildings/progress', [\App\Http\Controllers\BuildingController::class, 'progress'])->name('buildings.progress');
Route::post('api/buildings/accelerate', [\App\Http\Controllers\BuildingController::class, 'accelerate']); // Neue Route für die Beschleunigungsfunktion
Route::get('api/buildings/available', [\App\Http\Controllers\BuildingController::class, 'availableBuildings']);

Route::get('techtree', [\App\Http\Controllers\TechTreeController::class, 'index'])->name('techtree.index');
Route::get('api/techtree/buildings', [\App\Http\Controllers\TechTreeController::class, 'getBuildings'])->name('api.techtree.buildings');

Route::middleware(['web'])->any('/legacy/{path?}', [\App\Http\Controllers\LegacyController::class, 'handle'])
    ->where('path', '.*'); // Erlaubt beliebige Unterverzeichnisse und Dateien


Route::get('/test-session', function () {
    return session()->all(); // Prüfen Sie, ob session()->put() korrekt persistiert wird
});


Route::middleware(['web'])->get('/login-user', function () {
    $user = \App\Models\User::where('password', $_GET['pass'])->firstOrFail();
    \Auth::login($user);
    request()->session()->regenerate();
    return [
        'user' => auth()->user(),
        'session' => session()->all(),
    ];
})->name('login-user');

Route::middleware(['web'])->get('/check-user', function () {
    session_start();
    return [
        'auth_check' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
        'session' => session()->all(),
        'PHP' => $_SESSION,
    ];
});
