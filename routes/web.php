<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/user', [\App\Http\Controllers\ApiController::class, 'getUser'])->name('api.user');
Route::get('api/put/{id}', [\App\Http\Controllers\ApiController::class, 'put'])->name('api.put');
Route::post('api/put/{id}', [\App\Http\Controllers\ApiController::class, 'put'])->name('api.put');

Route::get('login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login.index');

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
Route::get('test', [\App\Http\Controllers\DashboardController::class, 'test'])->name('dashboard.index');

Route::resource('planets', \App\Http\Controllers\PlanetController::class);

Route::resource('building', \App\Http\Controllers\BuildingController::class);
Route::post('api/buildings/build', [\App\Http\Controllers\BuildingController::class, 'build'])->name('buildings.build');
Route::get('api/buildings/progress', [\App\Http\Controllers\BuildingController::class, 'progress'])->name('buildings.progress');
Route::post('api/buildings/accelerate', [\App\Http\Controllers\BuildingController::class, 'accelerate']); // Neue Route für die Beschleunigungsfunktion
Route::get('api/buildings/available', [\App\Http\Controllers\BuildingController::class, 'availableBuildings']);

Route::get('techtree', [\App\Http\Controllers\TechTreeController::class, 'index'])->name('techtree.index');
Route::get('api/techtree/buildings', [\App\Http\Controllers\TechTreeController::class, 'getBuildings'])->name('api.techtree.buildings');

Route::middleware(['web'])->any('/legacy/{path?}', [\App\Http\Controllers\LegacyController::class, 'handle'])
    ->where('path', '.*')->name('legacy'); // Erlaubt beliebige Unterverzeichnisse und Dateien


Route::get('/test-session', function () {
    return session()->all(); // Prüfen Sie, ob session()->put() korrekt persistiert wird
});

Route::get('/ranking/{id}', [\App\Http\Controllers\RankingController::class, 'index'])->name('ranking.index'); // Alle Chats
Route::get('/ranking', [\App\Http\Controllers\RankingController::class, 'index']); // Alle Chats


    Route::get('/chats', [ChatController::class, 'index']); // Alle Chats
    Route::get('/chats/{chat}', [ChatController::class, 'show']); // Nachrichten eines Chats
    Route::post('/chats/{chat}/send', [ChatController::class, 'sendMessage']); // Nachricht senden

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
