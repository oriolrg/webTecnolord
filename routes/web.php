<?php

use Illuminate\Support\Facades\Route;

// GRUP AMB MIDDLEWARE WEB (sessió, cookies, CSRF)
Route::middleware(['web'])->group(function () {

    // Ruta de prova
    Route::get('/test', function () {
        return 'Ruta test funciona!';
    });

    // Rutes generals
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/meteo', [App\Http\Controllers\HomeController::class, 'indexMeteo'])->name('home');
    Route::get('/saveMeteo', [App\Http\Controllers\MeteoController::class, 'saveDatabaseMeteo'])->name('home');

    // Rutes testsOpos
    Route::prefix('testsOpos')->group(function () {
        Route::get('/', [App\Http\Controllers\testsOposController::class, 'index'])->name('home');
        Route::get('/preguntest',  [App\Http\Controllers\testsOposController::class, 'getQuestion'])->name('home');
        Route::get('/errors', [App\Http\Controllers\ErrorController::class, 'index'])->name('home');
        Route::get('/preguntes', [App\Http\Controllers\testsOposController::class, 'index'])->name('home');
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
        Route::get('/pregunta/{error}/error', fn($error) => $error);
        Route::post('/pregunta/error', [App\Http\Controllers\ErrorController::class, 'insertError']);
        Route::post('/pregunta/ok',  [App\Http\Controllers\ErrorController::class, 'insertOk']);
        Route::get('/errors/imprimir',  [App\Http\Controllers\ErrorController::class, 'imprimirError']);
        Route::get('/edit/{id}', [App\Http\Controllers\testsOposController::class, 'editPregunta']);
        Route::post('/edit/guardar', [App\Http\Controllers\testsOposController::class, 'guardareditaPregunta']);
        Route::delete('/edit/eliminar/{id}', [App\Http\Controllers\testsOposController::class, 'eliminarPregunta']);
    });

    // OAuth Strava
    Route::get('/strava/auth', [App\Http\Controllers\StravaController::class, 'redirectToStrava']);
    Route::get('/strava/callback', [App\Http\Controllers\StravaController::class, 'handleStravaCallback']);

    // Test sessió
    Route::get('/strava/test-session', function () {
        return response()->json([
            'user_id' => session('user_id'),
            'session' => session()->all(),
        ]);
    });

    // API que depèn de sessió (React pot consultar això)
    Route::get('/api/user/strava', function () {
        if (session()->has('strava_user')) {
            return response()->json(session('strava_user'));
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    });

    // Rutes PRIVADES protegides amb sessió i middleware strava.auth
    Route::prefix('api/enruta')->group(function () {

        Route::get('/privat', [App\Http\Controllers\PrivateController::class, 'index']);

        Route::middleware(['strava.auth'])->group(function () {
            Route::get('/punts', fn() => response()->json([
                'missatge' => 'Accés a punts aconseguits',
                'usuari' => session('strava_user')
            ]));
        });
        // Logout
        Route::get('/logout', function () {
            session()->forget('strava_user');
            return redirect('/');
        });
    });

    

    // Debug sessió
    Route::get('/debug/session', function () {
        echo '<pre>';
        print_r(session()->all());
        echo '</pre>';
    });

});
