<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquestes rutes són pensades per API REST i no tenen accés a la sessió
| (a no ser que ho afegeixis manualment, cosa que no recomanem).
|
*/

// Exemples de rutes d'API pures, només per dades JSON públiques

// Predicció de pluja amb Machine Learning
Route::post('/predir-pluja', function (Request $request) {
    try {
        $resposta = Http::post('http://localhost:5000/predir', $request->all());
        return response()->json($resposta->json());
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error fent la predicció',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Rutes públiques de dades meteorològiques
Route::get('/meteo', [App\Http\Controllers\MeteoController::class, 'getMeteo']);
Route::get('/meteoPrevi', [App\Http\Controllers\MeteoController::class, 'getPreviMeteo']);
Route::get('/meteoMaxMin', [App\Http\Controllers\MeteoController::class, 'getMeteoMaxMin']);
Route::get('/getCabals', [App\Http\Controllers\MeteoController::class, 'getCabals']);

// Si StravaCallback no necessita sessió, pot estar aquí
Route::get('/strava/callback', [App\Http\Controllers\StravaController::class, 'handleStravaCallback']);

// Cims protegits amb middleware específic (si no es basa en sessió)
Route::middleware('check.strava.auth')->group(function () {
    Route::get('/cims', [App\Http\Controllers\CimController::class, 'index']);
    Route::post('/cims/{id}/complete', [App\Http\Controllers\CimController::class, 'complete']);
    Route::get('/cims/completed', [App\Http\Controllers\CimController::class, 'completed']);
});

// Usuari autenticat via API Token (normal Laravel)
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
use App\Http\Controllers\Api\EnrutaController;

Route::get('/enruta/items', [EnrutaController::class, 'index']);
Route::post('/enruta/items', [EnrutaController::class, 'store']);

Route::get('/enruta/items/{routeItem}', [EnrutaController::class, 'show']);
Route::get('/enruta/items/{routeItem}/track', [EnrutaController::class, 'track']);
Route::get('/enruta/items/{routeItem}/download-gpx', [EnrutaController::class, 'downloadGpx']);
