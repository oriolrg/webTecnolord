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
Route::get('/idioma/{lang}', [App\Http\Controllers\LanguageController::class, 'setLocale'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes(["register" => false]);

Route::get('/meteo',[App\Http\Controllers\MeteoController::class, 'index'])->name('home');
Route::get('/meteo/save',[App\Http\Controllers\MeteoController::class, 'saveMeteo'])->name('home');
Route::get('/meteo/dia/{dia}',[App\Http\Controllers\MeteoController::class, 'getMeteoDia'])->name('home');
Route::get('/meteo/dia/{dia}/mes/{mes}/any/{any}',[App\Http\Controllers\MeteoController::class, 'getMeteoDiaMesAny'])->name('home');
Route::get('/meteo/mes/{mes}/any/{any}',[App\Http\Controllers\MeteoController::class, 'getMesMeteo'])->name('home');
Route::get('/meteo/any/{any}',[App\Http\Controllers\MeteoController::class, 'getAnyMeteo'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Rutes Vista administra
 */
Route::group(['prefix'=>'administra','as'=>'administra.'], function(){
    Route::get('/', [App\Http\Controllers\AdministraController::class, 'index'])->name('home');
    Route::get('/projectes_publicats', [App\Http\Controllers\AdministraProjectesPublicatsController::class, 'index'])->name('home');
    Route::get('/clients', [App\Http\Controllers\AdministraClientsController::class, 'index'])->name('home');
    Route::get('/projectes', [App\Http\Controllers\AdministraProjectesController::class, 'index'])->name('home');
    Route::get('/histories_usuari', [App\Http\Controllers\AdministraHistoriesController::class, 'index'])->name('home');
    //Route::get('/sprints', [App\Http\Controllers\AdministraSprintsController::class, 'index'])->name('home');
    Route::get('/bugs', [App\Http\Controllers\AdministraBugsController::class, 'index'])->name('home');
});
/**
 * Rutes Vista clients
 */
Route::group(['prefix'=>'clients','as'=>'clients.'], function(){
    Route::get('/', [App\Http\Controllers\ClientController::class, 'index'])->name('home');
    Route::get('/clients', [App\Http\Controllers\AdministraClientsController::class, 'index'])->name('home');
    Route::get('/projectes', [App\Http\Controllers\ClientProjectesController::class, 'index'])->name('home');
    Route::get('/histories', [App\Http\Controllers\ClientHistoriesController::class, 'index'])->name('home');
    Route::get('/bugs', [App\Http\Controllers\ClientBugsController::class, 'index'])->name('home');
    Route::get('/sprints', [App\Http\Controllers\ClientSprintsController::class, 'index'])->name('home');
    Route::get('/incidencies', [App\Http\Controllers\ClientIncidenciesController::class, 'index'])->name('home');
});
/**
 * Rutes consultes api administra
 */
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    //rutes Administra Clients
    Route::group(['prefix'=>'clients','as'=>'clients.'], function(){
        Route::get('/', [App\Http\Controllers\AdministraClientsController::class, 'getClients'])->name('home');
        Route::delete('/eliminar', [App\Http\Controllers\AdministraClientsController::class, 'eliminarClient'])->name('home');
        Route::post('/nou', [App\Http\Controllers\AdministraClientsController::class, 'nouClient'])->name('home');
        Route::post('/actualitza', [App\Http\Controllers\AdministraClientsController::class, 'actualitzaClient'])->name('home');
    });
    //rutes Administra Projectes
    Route::group(['prefix'=>'projectes','as'=>'projectes.'], function(){
        Route::get('/', [App\Http\Controllers\AdministraProjectesController::class, 'getProjectes'])->name('home');
        Route::get('/doing', [App\Http\Controllers\AdministraProjectesController::class, 'getProjectesDoing'])->name('home');
        Route::delete('/eliminar', [App\Http\Controllers\AdministraProjectesController::class, 'eliminarProjecte'])->name('home');
        Route::post('/nou', [App\Http\Controllers\AdministraProjectesController::class, 'nouProjecte'])->name('home');
        Route::post('/actualitza', [App\Http\Controllers\AdministraProjectesController::class, 'actualitzaProjecte'])->name('home');
        Route::post('/finalitzar', [App\Http\Controllers\AdministraProjectesController::class, 'finalitzaProjecte'])->name('home');
    });
    //rutes Administra Histories
    Route::group(['prefix'=>'histories','as'=>'histories.'], function(){
        Route::get('/', [App\Http\Controllers\AdministraHistoriesController::class, 'getHistories'])->name('home');
        Route::delete('/eliminar', [App\Http\Controllers\AdministraHistoriesController::class, 'eliminarHistoria'])->name('home');
        Route::post('/nou', [App\Http\Controllers\AdministraHistoriesController::class, 'nouHistoria'])->name('home');
        Route::post('/actualitza', [App\Http\Controllers\AdministraHistoriesController::class, 'actualitzaHistoria'])->name('home');
        Route::post('/updateEstat', [App\Http\Controllers\AdministraHistoriesController::class, 'actualitzaEstatHistoria'])->name('home');
    });
    //rutes Administra bugs
    Route::group(['prefix'=>'bugs','as'=>'bugs.'], function(){
        Route::get('/', [App\Http\Controllers\AdministraBugsController::class, 'getBugs'])->name('home');
        Route::delete('/eliminar', [App\Http\Controllers\AdministraBugsController::class, 'eliminarBug'])->name('home');
        Route::post('/nou', [App\Http\Controllers\AdministraBugsController::class, 'nouBug'])->name('home');
        Route::post('/actualitza', [App\Http\Controllers\AdministraBugsController::class, 'actualitzaBug'])->name('home');
        Route::post('/updateEstat', [App\Http\Controllers\AdministraBugsController::class, 'actualitzaEstatBug'])->name('home');
    });
    //rutes Administra projectes publicats
    Route::group(['prefix'=>'projectesPublicats','as'=>'bugs.'], function(){
        Route::get('/', [App\Http\Controllers\AdministraProjectesPublicatsController::class, 'getProjectesDone'])->name('home');
        Route::get('/nou', [App\Http\Controllers\AdministraProjectesPublicatsController::class, 'nouProjectePublicar'])->name('home');
        Route::post('/publicar', [App\Http\Controllers\AdministraProjectesPublicatsController::class, 'publicarProjecte'])->name('home');
        Route::get('/finalitzar', [App\Http\Controllers\AdministraProjectesPublicatsController::class, 'amagarProjecte'])->name('home');
    });
});

/**
 * Rutes consultes api clients
 */
Route::group(['prefix'=>'client','as'=>'admin.'], function(){
    //rutes Cients Projectes
    Route::group(['prefix'=>'projectes','as'=>'projectes.'], function(){
        Route::get('/', [App\Http\Controllers\ClientProjectesController::class, 'getProjectes'])->name('home');
        Route::get('/doing', [App\Http\Controllers\ClientProjectesController::class, 'getProjectesDoing'])->name('home');
        Route::delete('/eliminar', [App\Http\Controllers\ClientProjectesController::class, 'eliminarProjecte'])->name('home');
        Route::post('/nou', [App\Http\Controllers\ClientProjectesController::class, 'nouProjecte'])->name('home');
        Route::post('/actualitza', [App\Http\Controllers\ClientProjectesController::class, 'actualitzaProjecte'])->name('home');
        Route::post('/finalitzar', [App\Http\Controllers\ClientProjectesController::class, 'finalitzaProjecte'])->name('home');
    });
    //rutes Clients Histories
    Route::group(['prefix'=>'histories','as'=>'histories.'], function(){
        Route::get('/', [App\Http\Controllers\ClientHistoriesController::class, 'getHistories'])->name('home');
        Route::delete('/eliminar', [App\Http\Controllers\ClientHistoriesController::class, 'eliminarHistoria'])->name('home');
        Route::post('/nou', [App\Http\Controllers\ClientHistoriesController::class, 'nouHistoria'])->name('home');
        Route::post('/actualitza', [App\Http\Controllers\ClientHistoriesController::class, 'actualitzaHistoria'])->name('home');
        Route::post('/updateEstat', [App\Http\Controllers\ClientHistoriesController::class, 'actualitzaEstatHistoria'])->name('home');
    });
    //rutes Administra bugs
    Route::group(['prefix'=>'bugs','as'=>'bugs.'], function(){
        Route::get('/', [App\Http\Controllers\ClientBugsController::class, 'getBugs'])->name('home');
        Route::delete('/eliminar', [App\Http\Controllers\ClientBugsController::class, 'eliminarBug'])->name('home');
        Route::post('/nou', [App\Http\Controllers\ClientBugsController::class, 'nouBug'])->name('home');
        Route::post('/actualitza', [App\Http\Controllers\ClientBugsController::class, 'actualitzaBug'])->name('home');
        Route::post('/updateEstat', [App\Http\Controllers\ClientBugsController::class, 'actualitzaEstatBug'])->name('home');
    });
});
/**
 * Rutes consultes api publiques
 */
Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'getCategories'])->name('home');
