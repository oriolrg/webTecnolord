<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::post('/predir-pluja', function (Request $request) {
    try {
        // Enviar les dades al servidor de Machine Learning
        $resposta = Http::post('http://localhost:5000/predir', $request->all());

        // Retornar JSON vàlid a la web
        return response()->json($resposta->json());
    } catch (\Exception $e) {
        // Si hi ha un error, retornar un missatge JSON amb codi 500
        return response()->json([
            'error' => 'Error fent la predicció',
            'message' => $e->getMessage()
        ], 500);
    }
});
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/meteo', [App\Http\Controllers\MeteoController::class, 'getMeteo'])->name('home');
Route::get('/meteoPrevi', [App\Http\Controllers\MeteoController::class, 'getPreviMeteo'])->name('home');
Route::get('/meteoMaxMin', [App\Http\Controllers\MeteoController::class, 'getMeteoMaxMin'])->name('home');

Route::get('/getCabals', [App\Http\Controllers\MeteoController::class, 'getCabals'])->name('home');

Route::get('/strava/callback', [App\Http\Controllers\StravaController::class, 'handleStravaCallback']);
Route::middleware('check.strava.auth')->group(function () {
    Route::get('/summits', [SummitController::class, 'index']);
    Route::post('/summits/{id}/complete', [SummitController::class, 'complete']);
    Route::get('/summits/completed', [SummitController::class, 'completed']);
});