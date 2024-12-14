<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('planets', \App\Http\Controllers\PlanetController::class);

Route::resource('building', \App\Http\Controllers\BuildingController::class);
Route::post('api/buildings/build', [\App\Http\Controllers\BuildingController::class, 'build'])->name('buildings.build');
Route::get('api/buildings/progress', [\App\Http\Controllers\BuildingController::class, 'progress'])->name('buildings.progress');
Route::post('api/buildings/accelerate', [\App\Http\Controllers\BuildingController::class, 'accelerate']); // Neue Route für die Beschleunigungsfunktion
Route::get('api/buildings/available', [\App\Http\Controllers\BuildingController::class, 'availableBuildings']);

Route::get('techtree', [\App\Http\Controllers\TechTreeController::class, 'index'])->name('techtree.index');
Route::get('api/techtree/buildings', [\App\Http\Controllers\TechTreeController::class, 'getBuildings'])->name('api.techtree.buildings');

Route::any('/legacy/{path?}', [\App\Http\Controllers\LegacyController::class, 'handle'])
    ->where('path', '.*'); // Erlaubt beliebige Unterverzeichnisse und Dateien
