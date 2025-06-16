<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/meteo', [App\Http\Controllers\HomeController::class, 'indexMeteo'])->name('home');
Route::get('/saveMeteo', [App\Http\Controllers\MeteoController::class, 'saveDatabaseMeteo'])->name('home');

Route::prefix('testsOpos')->group(function () {
Route::get('/', [App\Http\Controllers\testsOposController::class, 'index'])->name('home');


Route::get('/preguntest',  [App\Http\Controllers\testsOposController::class, 'getQuestion'])->name('home');
Route::get('/errors', [App\Http\Controllers\ErrorController::class, 'index'])->name('home');
Route::get('/preguntes', 'testsOposController@index')->name('home');
Route::get('/preguntes/{categoria}/{name}', [App\Http\Controllers\testsOposController::class, 'indexCategoria'])->name('home');
Route::get('/preguntes/preguntesfallades', [App\Http\Controllers\testsOposController::class, 'indexFallades'])->name('home');
Route::get('/preguntes/crearpregunta', [App\Http\Controllers\testsOposController::class, 'indexCrearPregunta'])->name('home');
Route::post('/preguntes/guardar', [App\Http\Controllers\testsOposController::class, 'guardarPregunta'])->name('home');
Route::get('/definicio', [App\Http\Controllers\DefinicioController::class,'index'])->name('home');
Route::get('/definicio/creardefinicio', [App\Http\Controllers\DefinicioController::class,'indexCrearDefinicio'])->name('home');
Route::post('/definicio/guardar', [App\Http\Controllers\DefinicioController::class,'guardarDefinicio'])->name('home');
Route::get('/definicio/edit/{id}', [App\Http\Controllers\DefinicioController::class,'indexEditarDefinicio'])->name('home');
Route::post('/definicio/edit/guardar', [App\Http\Controllers\DefinicioController::class,'editguardarDefinicio'])->name('home');
Route::get('/definicio/consulta/{id}', [App\Http\Controllers\DefinicioController::class,'consultaDefinicio'])->name('home');
Route::get('/pregunta/{error}/error', function ($error) {
    return $error;
});
Route::post('/pregunta/error', [App\Http\Controllers\ErrorController::class, 'insertError']);
Route::post('/pregunta/ok',  [App\Http\Controllers\ErrorController::class, 'insertOk']);
Route::get('/errors/imprimir',  [App\Http\Controllers\ErrorController::class, 'imprimirError']);
Route::get('/edit/{id}', [App\Http\Controllers\testsOposController::class, 'editPregunta']);
Route::post('/edit/guardar', [App\Http\Controllers\testsOposController::class, 'guardareditaPregunta']);
Route::delete('/edit/eliminar/{id}', [App\Http\Controllers\testsOposController::class, 'eliminarPregunta']);
});

/*
Strava OAuth
**/

Route::get('/strava/auth', [App\Http\Controllers\StravaController::class, 'redirectToStrava']);
Route::get('/strava/callback', [App\Http\Controllers\StravaController::class, 'handleStravaCallback']);


//test
Route::get('/strava/test-session', function () {
    return session('strava_user');
});

Route::get('/api/user/strava', function () {
    if (session()->has('strava_user')) {
        return response()->json(session('strava_user'));
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});
Route::middleware(['strava.auth'])->group(function () {
    /*Route::get('/enruta/privat', function () {
        return view('enruta.index'); // mateixa vista, però ruta protegida
    });*/
    Route::get('/enruta/privat', [App\Http\Controllers\HomeController::class, 'indexMeteo'])->name('home');

    Route::get('/enruta/punts', function () {
        return response()->json([
            'missatge' => 'Accés a punts aconseguits',
            'usuari' => session('strava_user')
        ]);
    });
});
//Route::get('/enruta/privat', [App\Http\Controllers\HomeController::class, 'indexMeteo'])->name('home');

Route::get('/logout', function () {
    session()->forget('strava_user');
    return redirect('/enruta');
});
